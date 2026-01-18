import cv2
import face_recognition
import numpy as np
import os
import pyttsx3
import requests

# ==============================
# CONFIG
# ==============================
KNOWN_FACES_DIR = "known_faces"
LARAVEL_API_URL = "http://127.0.0.1:8000/api/recognize"

# ==============================
# LOAD KNOWN FACES
# ==============================
known_encodings = []
known_names = []

for file in os.listdir(KNOWN_FACES_DIR):
    if file.endswith(".npy"):
        name = file.replace(".npy", "")
        encoding = np.load(os.path.join(KNOWN_FACES_DIR, file))
        known_encodings.append(encoding)
        known_names.append(name)

print("Loaded known faces:", known_names)

# ==============================
# TEXT TO SPEECH
# ==============================
engine = pyttsx3.init()
engine.setProperty("rate", 160)

# ==============================
# FUNCTION: SEND NAME TO LARAVEL
# ==============================
def send_to_laravel(name):
    try:
        response = requests.post(
            LARAVEL_API_URL,
            json={"name": name},
            timeout=2
        )
        return response.json()
    except Exception as e:
        print("Laravel API error:", e)
        return None

# ==============================
# CAMERA SETUP
# ==============================
video_capture = cv2.VideoCapture(0, cv2.CAP_DSHOW)

if not video_capture.isOpened():
    print("❌ Camera not accessible")
    exit()

spoken_names = set()

print("Press Q to quit")

# ==============================
# MAIN LOOP
# ==============================
while True:
    ret, frame = video_capture.read()
    if not ret:
        break

    frame = frame.copy()

    # Convert to RGB
    rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
    rgb_frame = np.ascontiguousarray(rgb_frame)

    # Detect faces
    face_locations = face_recognition.face_locations(rgb_frame, model="hog")
    face_encodings = face_recognition.face_encodings(rgb_frame, face_locations)

    for encoding, (top, right, bottom, left) in zip(face_encodings, face_locations):

        matches = face_recognition.compare_faces(
            known_encodings, encoding, tolerance=0.5
        )

        name = "Unknown"
        details_text = ""

        if True in matches:
            index = matches.index(True)
            name = known_names[index]

            # Call Laravel only once per person
            if name not in spoken_names:
                api_response = send_to_laravel(name)

                if api_response and api_response.get("status") == "success":
                    details = api_response.get("details", "")
                    details_text = f"{name}. {details}"
                else:
                    details_text = f"Hello {name}"

                engine.say(details_text)
                engine.runAndWait()
                spoken_names.add(name)

        # Draw box and label
        cv2.rectangle(frame, (left, top), (right, bottom), (0, 255, 0), 2)
        cv2.putText(
            frame,
            name,
            (left, top - 10),
            cv2.FONT_HERSHEY_SIMPLEX,
            0.9,
            (0, 255, 0),
            2
        )

    cv2.imshow("Face Recognition & Voice", frame)

    if cv2.waitKey(1) & 0xFF == ord("q"):
        break

# ==============================
# CLEANUP
# ==============================
video_capture.release()
cv2.destroyAllWindows()

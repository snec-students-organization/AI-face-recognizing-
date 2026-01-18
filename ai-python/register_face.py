import cv2
import face_recognition
import numpy as np
import os

# Folder to store known faces
KNOWN_FACES_DIR = "known_faces"
os.makedirs(KNOWN_FACES_DIR, exist_ok=True)

# Ask for person's name
name = input("Enter person's name: ").strip().lower()

video_capture = cv2.VideoCapture(0, cv2.CAP_DSHOW)

print("Press S to save face | Press Q to quit")

while True:
    ret, frame = video_capture.read()
    if not ret:
        print("Failed to read frame")
        break

    frame = frame.copy()
    rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
    rgb_frame = np.ascontiguousarray(rgb_frame)

    face_locations = face_recognition.face_locations(rgb_frame, model="hog")
    face_encodings = face_recognition.face_encodings(rgb_frame, face_locations)

    for (top, right, bottom, left) in face_locations:
        cv2.rectangle(frame, (left, top), (right, bottom), (0, 255, 0), 2)

    cv2.imshow("Register Face", frame)

    key = cv2.waitKey(1) & 0xFF

    if key == ord("s"):
        if len(face_encodings) == 1:
            encoding = face_encodings[0]
            path = os.path.join(KNOWN_FACES_DIR, f"{name}.npy")
            np.save(path, encoding)
            print(f"✅ Face saved for {name}")
            break
        else:
            print("❌ Make sure only ONE face is visible")

    if key == ord("q"):
        break

video_capture.release()
cv2.destroyAllWindows()

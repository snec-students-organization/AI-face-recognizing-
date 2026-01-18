import cv2
import face_recognition
import numpy as np

# Force Windows DirectShow backend
video_capture = cv2.VideoCapture(0, cv2.CAP_DSHOW)

# Optional: set resolution (stabilizes frames)
video_capture.set(cv2.CAP_PROP_FRAME_WIDTH, 640)
video_capture.set(cv2.CAP_PROP_FRAME_HEIGHT, 480)

if not video_capture.isOpened():
    print("❌ Camera not accessible")
    exit()

print("Press Q to quit")

while True:
    ret, frame = video_capture.read()
    if not ret:
        print("❌ Failed to grab frame")
        break

    # Make a SAFE copy of the frame
    frame = frame.copy()

    # Ensure correct dtype
    if frame.dtype != np.uint8:
        frame = frame.astype(np.uint8)

    # Convert BGR → RGB
    rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)

    # Ensure contiguous memory (CRITICAL)
    rgb_frame = np.ascontiguousarray(rgb_frame)

    # Face detection
    face_locations = face_recognition.face_locations(
        rgb_frame,
        number_of_times_to_upsample=1,
        model="hog"
    )

    # Draw boxes
    for top, right, bottom, left in face_locations:
        cv2.rectangle(frame, (left, top), (right, bottom), (0, 255, 0), 2)

    cv2.imshow("Face Detection", frame)

    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

video_capture.release()
cv2.destroyAllWindows()

from flask import Flask, request, jsonify
import face_recognition
import numpy as np
import os

app = Flask(__name__)

KNOWN_FACES_DIR = "known_faces"
os.makedirs(KNOWN_FACES_DIR, exist_ok=True)

@app.route("/delete", methods=["POST"])
def delete_face():
    data = request.json
    name = data.get("name")

    if not name:
        return jsonify({"status": "error", "message": "Name is required"}), 400

    npy_path = os.path.join(KNOWN_FACES_DIR, f"{name}.npy")
    
    if os.path.exists(npy_path):
        os.remove(npy_path)
        return jsonify({"status": "success", "message": f"Biometric data for {name} deleted"})
    
    return jsonify({"status": "error", "message": "Biometric record not found"}), 404

@app.route("/", methods=["GET"])
def health_check():
    return jsonify({"status": "active", "service": "AG AI Biometric Engine"})

@app.route("/recognize", methods=["POST"])
def recognize_face():
    data = request.json
    image_path = data.get("image_path")

    if not image_path or not os.path.exists(image_path):
        return jsonify({"status": "error", "message": "Image not found"}), 404

    # Load known encodings
    known_encodings = []
    known_names = []

    for file in os.listdir(KNOWN_FACES_DIR):
        if file.endswith(".npy"):
            name = file.replace(".npy", "")
            encoding = np.load(os.path.join(KNOWN_FACES_DIR, file))
            known_encodings.append(encoding)
            known_names.append(name)

    if not known_encodings:
        return jsonify({"status": "unknown", "message": "No known faces found"})

    # Process target image
    image = face_recognition.load_image_file(image_path)
    face_locations = face_recognition.face_locations(image)
    
    if len(face_locations) == 0:
        print(f"DEBUG: No face detected in {image_path}")
        return jsonify({"status": "unknown", "message": "No face detected"})

    print(f"DEBUG: Face detected, encoding...")
    target_encoding = face_recognition.face_encodings(image, face_locations)[0]

    # Compare
    # Increase tolerance to 0.6 (standard) for better matching
    tolerance = 0.6
    matches = face_recognition.compare_faces(known_encodings, target_encoding, tolerance=tolerance)
    
    # Also get distances for debugging
    face_distances = face_recognition.face_distance(known_encodings, target_encoding)
    best_match_index = np.argmin(face_distances)
    
    print(f"DEBUG: Distances: {list(zip(known_names, face_distances))}")

    if matches[best_match_index]:
        name = known_names[best_match_index]
        print(f"DEBUG: Match found! {name} (dist: {face_distances[best_match_index]:.4f})")
        return jsonify({"status": "success", "name": name})

    print(f"DEBUG: No match found. Closest: {known_names[best_match_index]} (dist: {face_distances[best_match_index]:.4f})")
    return jsonify({"status": "unknown", "message": "Person not recognized"})


@app.route("/encode", methods=["POST"])
def encode_face():
    data = request.json

    name = data.get("name")
    image_path = data.get("image_path")

    if not name or not image_path:
        return jsonify({"status": "error", "message": "Missing data"}), 400

    if not os.path.exists(image_path):
        return jsonify({"status": "error", "message": "Image not found"}), 404

    image = face_recognition.load_image_file(image_path)
    face_locations = face_recognition.face_locations(image)

    if len(face_locations) != 1:
        return jsonify({
            "status": "error",
            "message": "Image must contain exactly one face"
        }), 400

    encoding = face_recognition.face_encodings(image, face_locations)[0]

    npy_path = os.path.join(KNOWN_FACES_DIR, f"{name}.npy")
    np.save(npy_path, encoding)

    return jsonify({
        "status": "success",
        "message": f"Face encoded for {name}"
    })

if __name__ == "__main__":
    print("--------------------------------------------------")
    print("🚀 AG AI BIOMETRIC ENGINE IS STARTING...")
    print("📍 URL: http://127.0.0.1:5001")
    print("✅ System Ready for Scans")
    print("--------------------------------------------------")
    app.run(port=5001)

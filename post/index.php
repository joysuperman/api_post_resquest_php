<?php
    header('Content-Type: application/json');

    // Include the database connection file
    include '../connection.php';

    // Validate All Input
    function validateInput($data) {
        // Empty Check
        if (empty($data['product_id']) || empty($data['user_id']) || empty($data['ratings']) || empty($data['review_text'])) {
            return "All fields are required.";
        }

        // Numeric Check
        if (!is_numeric($data['product_id']) || !is_numeric($data['user_id']) || !is_numeric($data['ratings'])) {
            return "Invalid product ID or user ID.";
        }
        return null;
    }

    //Data Save After Validation
    function saveReviewToDatabase($data) {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO `reviews`(`product_id`, `user_id`, `ratings`, `review_text`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $data['product_id'], $data['user_id'], $data['ratings'], $data['review_text']);
        $stmt->execute();
        $stmt->close();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'product_id' => filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT),
            'user_id' => filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT),
            'ratings' => filter_input(INPUT_POST, 'ratings', FILTER_VALIDATE_INT),
            'review_text' => filter_input(INPUT_POST, 'review_text', FILTER_SANITIZE_STRING),
        ];

        // Check Validation
        $validationResult = validateInput($data);

        if ($validationResult === null) {
            saveReviewToDatabase($data);
            echo json_encode(['message' => 'Review submitted successfully']);
        } else {
            echo json_encode(['error' => $validationResult]);
        }
    } else {
        echo json_encode(['error' => 'Only POST requests are allowed']);
    }

    $conn->close();
?>
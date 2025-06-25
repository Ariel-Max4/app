<?php
require_once 'config/openai.php';

class ChatGPT {
    private $apiKey;
    private $apiUrl;

    public function __construct() {
        $this->apiKey = OPENAI_API_KEY;
        $this->apiUrl = OPENAI_API_URL;
    }

    public function getProductInfo($productName) {
        $prompt = "Tell me about the product '{$productName}'. Please provide information in the following format:
        
        BENEFITS: List the health benefits and positive aspects of this product.
        
        ENVIRONMENTAL: Describe the environmental impact of this product, including production, usage, and disposal.
        
        ADDITIONAL: Any other important information about this product.
        
        Please be clear, informative, and use simple terms.";

        return $this->makeApiCall($prompt);
    }

    public function getCategoryInfo($categoryName) {
        $prompt = "Tell me about the product category '{$categoryName}'. Please provide information in the following format:
        
        OVERVIEW: General overview of this product category.
        
        BENEFITS: Common health benefits and positive aspects of products in this category.
        
        ENVIRONMENTAL: Environmental impact of products in this category.
        
        EXAMPLES: List some common examples of products in this category.
        
        Please be clear, informative, and use simple terms.";

        return $this->makeApiCall($prompt);
    }

    public function analyzeProductImage($productName) {
        $prompt = "I have identified a product called '{$productName}' from an image. Please provide information in the following format:
        
        BENEFITS: List the health benefits and positive aspects of this product.
        
        ENVIRONMENTAL: Describe the environmental impact of this product.
        
        ADDITIONAL: Any other important information about this product.
        
        Please be clear, informative, and use simple terms.";

        return $this->makeApiCall($prompt);
    }

    private function makeApiCall($prompt) {
        $data = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'max_tokens' => 1000,
            'temperature' => 0.7
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception("API request failed with status code: $httpCode");
        }

        $responseData = json_decode($response, true);
        
        if (!isset($responseData['choices'][0]['message']['content'])) {
            throw new Exception("Invalid API response format");
        }

        $content = $responseData['choices'][0]['message']['content'];
        return $this->parseResponse($content);
    }

    private function parseResponse($content) {
        $result = [];
        
        // Parse the structured response
        if (preg_match('/OVERVIEW:\s*(.*?)(?=BENEFITS:|ENVIRONMENTAL:|ADDITIONAL:|$)/s', $content, $matches)) {
            $result['overview'] = trim($matches[1]);
        }
        
        if (preg_match('/BENEFITS:\s*(.*?)(?=OVERVIEW:|ENVIRONMENTAL:|ADDITIONAL:|EXAMPLES:|$)/s', $content, $matches)) {
            $result['benefits'] = trim($matches[1]);
        }
        
        if (preg_match('/ENVIRONMENTAL:\s*(.*?)(?=OVERVIEW:|BENEFITS:|ADDITIONAL:|EXAMPLES:|$)/s', $content, $matches)) {
            $result['environmental'] = trim($matches[1]);
        }
        
        if (preg_match('/ADDITIONAL:\s*(.*?)(?=OVERVIEW:|BENEFITS:|ENVIRONMENTAL:|EXAMPLES:|$)/s', $content, $matches)) {
            $result['additional'] = trim($matches[1]);
        }
        
        if (preg_match('/EXAMPLES:\s*(.*?)(?=OVERVIEW:|BENEFITS:|ENVIRONMENTAL:|ADDITIONAL:|$)/s', $content, $matches)) {
            $result['examples'] = trim($matches[1]);
        }

        // If parsing fails, return the full content
        if (empty($result)) {
            $result['benefits'] = $content;
            $result['environmental'] = "Environmental information not available in the expected format.";
        }

        return $result;
    }
}
?>
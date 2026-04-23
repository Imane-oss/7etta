@extends('layout')

@section('title', ' FAQ')

@section('content')

    <style>
        /* --- CSS: Design o Styling --- */
        :root {
            --primary-color: #2c3e50; 
            --accent-color: #01090f;  
            --bg-color: #c0c9d261;      
            --text-color: #333;
            --border-radius: 8px;
        }
body {
    background-color: var(--bg-color);
    margin: 0;
    padding: 0; /* مهم بزاف */
}

        .faq-container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .faq-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .faq-header h1 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .faq-header p {
            color: #575555;
        }

        /* Styling dyal details o summary */
        details {
            margin-bottom: 15px;
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            overflow: hidden;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        details:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-color: var(--accent-color);
        }

        summary {
            padding: 20px;
            cursor: pointer;
            font-weight: 600;
            color: var(--primary-color);
            list-style: none; /* Bach n7yiw ltriangle dyal default */
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Icon + bach tbdel */
        details {
            margin-bottom: 15px;
            border: 1px solid #eee;
            border-radius: var(--border-radius);
            background: #fff;
            transition: all 0.2s ease;
        }

        details:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-color: #ccc;
        }

        details[open] {
            border-left: 4px solid var(--primary-color); /* Indicateur dyal selection */
        }

        summary {
            padding: 18px 20px;
            font-weight: 600;
            cursor: pointer;
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.05rem;
        }

        /* Ikon + */
        summary::after {
            content: '+';
            font-size: 20px;
            color: #888;
            transition: transform 0.2s;
        }

        details[open] summary::after {
            transform: rotate(45deg);
            color: var(--primary-color);
        }

        details[open] summary {
            color: var(--primary-color);
            background-color: #fafafa;
            border-bottom: 1px solid #eee;
        }

         .faq-content {
            padding: 20px;
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive l Mobile */
        @media (max-width: 600px) {
            .faq-container {
                padding: 20px;
            }
        }

    .cta-footer {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 60px;
            padding-top: 40px;
            border-top: 1px solid #eee;
        }
        .btn-contact {
            display: inline-block;
            background-color: #0c0d0dc6;
            color: #fff;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-contact:hover {
            background-color: #3c3f3fc6;
        }

    </style>


    <div class="faq-container">
        <div class="faq-header">
            <h1>FAQ</h1>
            <p>Suggested questions</p>
        </div>

        <!-- Item 1 -->
        <details>
            <summary>What payment methods do you accept?</summary>
            <div class="faq-content">
               We accept payments by credit card (Visa, MasterCard), PayPal, and cash on delivery in certain areas. All transactions are secure.
            </div>
        </details>

        <!-- Item 2 -->
        <details>
            <summary>Comment that passes the product guarantee?</summary>
            <div class="faq-content">
                All our products come with a 1-year legal guarantee of conformity. In the event of a manufacturing defect, you can return the product for an exchange or a full refund.
            </div>
        </details>

        <!-- Item 3 -->
        <details>
            <summary>Can I cancel my order after it has been validated?</summary>
            <div class="faq-content">
               Yes, you have 2 hours after confirmation to cancel your order. After this time, please contact our customer service to check the shipping status.
            </div>
        </details>

        <!-- Item 4 -->
        <details>
            <summary>What are the delivery times?</summary>
            <div class="faq-content">
                Delivery times vary between 24 and 72 hours depending on your city of residence. You will receive a tracking number by SMS and email as soon as your package is shipped.
            </div>
        </details>

        <!-- Item 5 -->
        <details>
            <summary>Are my personal data secure?</summary>
            <div class="faq-content">
                Absolutely. We are committed to complying with all applicable regulations regarding the protection of personal data. Your information will never be sold to third parties.
            </div>
        </details>

    </div>
     <!-- btn-contact -->
       <div class="cta-footer">
            <p>Didn't find an answer to your question?</p>
            <a href="Contact.php" class="btn-contact">Contact Customer Service</a>
        </div>

@endsection

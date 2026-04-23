@extends('layout')

@section('title', 'retour')

@section('content')

    <style>
       

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #ffffff;
            color: #333333;
            /* L-faraq li fl-janb dial l-page */
            padding: 0;
            
        }

        

        header {
            text-align: center;
            margin-bottom: 70px;
        }

        h1 {
            font-size: 48px; /* Kbira o rbiqa bhal tswira */
            font-weight: 300;
            color: #fffefe;
            letter-spacing: 1px;
        }

        .content {
            text-align: left;
        }

        p {
            margin-bottom: 40px; /* L-faraq bin l-paragraphes */
            font-size: 17px;
            color: #4a4a4a;
            font-weight: 400;
        }

        .note {
            margin-top: 10px;
        }

    </style>


    <div class="container">
        <header>
            <h1>Remboursements / Échanges</h1>
        </header>

        <section class="content">
            <p>
                To be eligible for a return and/or exchange, your item(s) must be unused, unworn, and in the original condition and packaging (if applicable) that you received it in within 30 days of purchase. Unfortunately after 30 days, we are unable to process any returns or exchanges.
            </p>

            <p>
                Once your return is received and inspected, we will send you an email to notify you that we have received your returned item. We will also notify you of the approval or rejection of your refund. If your refund is approved, then your refund will be processed, and a credit will automatically be applied to the original method of payment, within 3 to 6 business days, for the value of the item returned and any applicable taxes associated with the item. Shipping costs are NON-REFUNDABLE.
            </p>

            <p>
                Once your exchange is received, we will send you an email to notify you that we have received your returned item. We will also notify you of the status of your exchange and tracking information for the exchanged item back to you.
            </p>

            <p>
                You will be responsible for paying for your own shipping costs for returning your item. Shipping costs to you are non-refundable. If you are shipping an item over $75, you should consider using a trackable shipping service or purchasing shipping insurance. We don't guarantee and cannot be held responsible if we do not receive your returned item. Depending on where you live, the time it may take for your exchanged product to reach you, may vary.
            </p>

            <p class="note">
                For ALL returns/exchanges, please e-mail us at  and include your order number to initiate the refund/exchange process.
            </p>
        </section>
    </div>



@endsection

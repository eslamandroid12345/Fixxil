@section('hyper_form')
    <div id="paymentWidgetsContainer"></div>

    <script>
        // Define wpwlOptions for payment widget
        var wpwlOptions = {
            style: "card"
        };

        // Apply body background color dynamically
        document.body.style.backgroundColor = '#f6f6f5';

        // Create script tag for payment widget
        var scriptTag = document.createElement('script');
        // scriptTag.src = 'https://eu-prod.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $responseData['id'] }}';
        scriptTag.src = 'https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $responseData['id'] }}';
        scriptTag.async = true;

        scriptTag.onload = function() {
            // Dynamically load additional stylesheets if required
            var styleSheetTag = document.createElement('link');
            styleSheetTag.rel = 'stylesheet';
            styleSheetTag.href = 'https://eu-prod.oppwa.com/v1/paymentWidgetsStyles.css';

            // Append the stylesheet to the head
            document.head.appendChild(styleSheetTag);

            // Render the form after loading the stylesheet
            var form = document.createElement('form');
            form.action = '{{ route('hyper_pay_checker', ['type' => $paymentType, 'id' => $responseData['id']]) }}';
            form.className = 'paymentWidgets ' + wpwlOptions.style;

            // Apply border styling to the form
            form.style.border = '1px solid #ccc';

            // Conditionally set the data-brands attribute based on the payment type
            @if ($paymentType == '1')
                form.setAttribute('data-brands', 'VISA MASTER AMEX');
            @elseif ($paymentType == '2')
                form.setAttribute('data-brands', 'MADA');
            @elseif($paymentType == '3')
                form.setAttribute('data-brands', 'APPLEPAY');
            @endif
            // Append the form to the desired container
            document.getElementById('paymentWidgetsContainer').appendChild(form);
        };

        // Append the script tag to the head
        document.head.appendChild(scriptTag);
    </script>
@endsection

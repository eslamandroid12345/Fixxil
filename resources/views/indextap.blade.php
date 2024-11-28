
<link rel="shortcut icon" href="https://goSellJSLib.b-cdn.net/v1.6.0/imgs/tap-favicon.ico" />

<link href="https://goSellJSLib.b-cdn.net/v1.6.0/css/gosell.css" rel="stylesheet" />
<script src="https://goSellJSLib.b-cdn.net/v1.6.0/js/gosell.js" type="text/javascript"></script>

@if(!isset($payment_gateway))
<div class="checkout-page">
    <div class="container">
        <div class="row payment-methods_row">
        <a href="{{ route('payment_gateways','tap') }}" class=" btn btn-info"> first payment method </a><br>
{{--        <a href="{{ route('payment_gateways','hyper_pay' ) }}" class="btn btn-info"> secound payment method</a>--}}

        </div>
    </div>
</div>

 @endif
<div class="checkout-page">
    <div class="container">
        <div class="row payment-methods_row">
                @if(isset($payment_gateway)&&$payment_gateway=='tap')
                <div class="payment-method">
                    <h3 class="text-center payment-method__title">tap pay</h3>
                    <input type="number" id="amount" name="amount" value="1" />
                    <button id="checkoutBtn" onclick="save()">
                        Checkouts
                    </button>
                </div>
                @endif

            </div>
        </div>
            <div id="hpay"></div>
        <div class="status-container">
            @isset($status)

            @if( $status ==1)
            <div class="alert alert-success">
                <strong>Success:</strong> Payment was successful.
            </div>
            @elseif( $status == 0)
            <div class="alert alert-danger">
                <strong>Error:</strong> Payment failed.
            </div>
            @else
            <div class="alert alert-danger">
                <strong>Error:</strong> not even set.{{ $status }}
            </div>
            <!-- Handle other cases if needed -->
            @endif
            @endisset
        </div>
    </div>


    {{-- <script src="{{asset('public/js/checkout/config.js')}}" type="text/javascript"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function save() {
            const button = document.getElementById("checkoutBtn");
            button.disabled = true;
            goSell.config({
                gateway: {
                    publicKey: "pk_test_fVLeKbYtuoXxZpHrym0PgABS",
                    // merchant_id: "1124340",
                    merchant_id: null,
                    language: "ar",
                    contactInfo: false,
                    supportedCurrencies: "all",
                    supportedPaymentMethods: "all",
                    saveCardOption: true,
                    customerCards: true,
                    notifications: "standard",
                    callback: (response) => {
                        console.log("callback", response);
                    },
                    onClose: () => {
                        console.log("onclose hey");
                    },
                    onLoad: () => {
                        console.log("onLoad");
                        goSell.openLightBox();
                    },
                    style: {
                        base: {
                            color: "red",
                            lineHeight: "10px",
                            fontFamily: "sans-serif",
                            fontSmoothing: "antialiased",
                            fontSize: "10px",
                            "::placeholder": {
                                color: "rgba(0, 0, 0, 0.26)",
                                fontSize: "10px",
                            },
                        },
                        invalid: {
                            color: "red",
                            iconColor: "#fa755a ",
                        },
                    },
                },
                customer: {
                    first_name: "hussein",
                    middle_name: "h",
                    last_name: "zaher",
                    email: "test@test.com",
                    phone: {
                        country_code: "+965",
                        number: "00000000",
                    },
                },
                order: {
                    amount: document.getElementById("amount").value,
                    currency: "SAR",
                    items: [{
                        id: 0,
                        name: "Item ",
                        description: "Item Desc 0",
                        old_quantity: 1,
                        quantity: 1,
                        amount_per_unit: 0,
                        old_total_amount: 0,
                        total_amount: 10,
                    }, ],
                },
                transaction: {
                    mode: "charge",
                    charge: {
                        auto: {
                            time: 100,
                            type: "VOID",
                        },
                        saveCard: false,
                        threeDSecure: true,
                        description: "description",
                        statement_descriptor: "statement_descriptor",
                        reference: {
                            transaction: "txn_0001",
                            order: "ord_0001",
                        },
                        metadata: {},
                        receipt: {
                            email: false,
                            sms: true,
                        },
                        redirect: "https://biz-deal.net/callback_tap_pay",
                        post: "https://biz-deal.net/post_callback_tap_pay",
                    },
                },
            });
        }
    </script>
    <script>
        function saveHyper() {
            var amount = document.getElementById('hyper_amount').value;

            // Assuming you have radio buttons with the name "payment_type"
            var selectedValue = document.querySelector('input[name="payment_type"]:checked');

            // If a radio button is selected, selectedValue will contain the selected radio button's value
            if (selectedValue) {
                var paymentType = selectedValue.value;

                // Set the entityId based on the selected payment type
                // Make an AJAX request to your controller
                $.ajax({
                    url: '{{ route('check_out_hyper_pay') }}', // Replace with the actual route to your controller
                    method: 'get',
                    data: {
                        paymentType: paymentType,
                        amount: amount,
                    },
                    success: function(response) {
                        // console.log(response);
                        // if (response.status == true) {
                            $(hpay).empty().html(response.form);
                        // }
                    },
                    error: function(error) {
                        // Handle the error response from your controller
                        console.error(error);
                    }
                });
            } else {
                console.log('No payment type selected');
                // Handle the case where no option is selected...
            }
        }
    </script>


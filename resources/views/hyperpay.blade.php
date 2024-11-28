
<h1>Test Hyper Pay</h1>

    <div class="commission-page">
        <div class="text-center">
            <hr>
            <div class="checkout-page">
                <div class="container">
                    <div class="row payment-methods_row">
                            <div class="payment-method">
                                <h3 class="text-center payment-method__title">دفع العمولة</h3>
                                <input type="number" id="hyper_amount" name="hyper_amount" value="1" />
                                <form class="payment-form d-flex ">
                                    <div class="payment-option">
                                        <label for="mada"><img  src="{{asset("assets/mada-logo.svg")}}" width="150"></label>
                                        <input type="radio" id="mada" name="payment_type" value="2" checked>
                                    </div>
                                    <div class="payment-option">
                                        <label for="payment_cards"><img src="{{asset("assets/visa.png")}}" width="150"></label>
                                        <input type="radio" id="payment_cards" name="payment_type" value="1">
                                    </div>
                                    <div class="payment-option">
                                        <label for="apple"><img src="{{asset("assets/apple-pay.png")}}" width="150"></label>
                                        <input type="radio" id="apple" name="payment_type" value="3">
                                    </div>
                                </form>
                                <button id="checkoutBtn" onclick="saveHyper()">
                                    ادفع
                                </button>
                            </div>
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
            {{-- <hr> --}}
        </div>

    </div>


    <script>
        $(document).ready(function () {


            $('#price').on('change', function () {

                fetch('{{url('countCommission')}}?price=' + $('#price').val())
                    .then(response => response.json())
                    .then(data => {
                        $('#commission').val(data);
                        $('#commission_amount').val(data);
                        // $('#comm').val(data);
                    })
                    .catch(function (error) {
                        console.warn('Something went wrong.', error);
                    });
            });
        });

    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function saveHyper()
    {
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



<style>
    .payment-form {
        display: flex !important;
        gap: 2rem !important;
        align-items: center !important;
    }

    .payment-option {
        display: flex !important;
    }
</style>



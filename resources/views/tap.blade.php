


    <div class="commission-page">
        <div class="text-center">
            <hr>
            <h1>Test Tap Pay</h1>
            <div class="btnWrapper">
                <a class="payBtn mada checkoutBtn" id="checkoutBtn" onclick="save()">
                    <span>@lang('site.Click here to pay with')</span>
                    <div class="pay_btn_icon_wrapper">
                        <a class="payBtnLink" href="{{route('check_out_tap_pay')}}">
                            <img src="{{asset("assets/apple-pay.png")}}" width="150">
                        </a>
                        <a class="payBtnLink" href="{{route('check_out_tap_pay')}}">
                            <img  src="{{asset("assets/mada-logo.svg")}}" width="150">
                        </a>
                        <a class="payBtnLink" href="{{route('check_out_tap_pay')}}">
                            <img src="{{asset("assets/visa.png")}}" width="150">
                        </a>
                    </div>
                </a>
            </div>
            <hr>
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



@extends('front.layout')

@section('main')
    <div class="row">
        <div class="column large-12">

            <div class="s-content__entry-header">
                <h1 class="s-content__title">
                Souscrire au plan {{request('plan')}}</h1>
            </div>

            <div class="row row-x-center">
                <div class="column large-6 tab-12">

                    <!-- Session Status -->
                    <x-auth.session-status :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth.validation-errors :errors="$errors" />

                    <form id="payment-form" class="s-content__form" method="post" action="{{ route('payment.store') }}">
                        @csrf
                        <fieldset>

                            <input type="hidden" name="plan" id="plan" value="{{request('plan')}}">
                            <input type="hidden" name="payment-method" id="payment-method">
                            <div>
                                <label for="card-holder-name">@lang('Name')</label>
                                <input
                                    id="card-holder-name"
                                    class="h-full-width"
                                    type="text"
                                    name="name"
                                    placeholder="@lang('Your name')"
                                    value="{{ old('name') ?? auth()->user()->name }}"
                                    required
                                    autofocus>
                            </div>

                            <div>
                                <label for="name">@lang('Email')</label>
                                <input
                                    id="email"
                                    class="h-full-width"
                                    type="email"
                                    name="email"
                                    placeholder="@lang('Your name')"
                                    value="{{ old('email') ?? auth()->user()->email }}"
                                    required
                                    autofocus>
                            </div>
                            <!-- Stripe Elements Placeholder -->

                            <div>
                                <label for="name">Information sur le carte</label>
                                <div id="card-element" class="h-full-width"></div>
                            </div>

                            <br>
                            <div id="card-errors" class="h-full-width"></div>
                            <br>

                            <p id="forSubmit" class="text-center">
                                <input name="submit" id="card-button" class="btn btn--primary btn-wide btn--large h-full-width"
                                       data-secret="{{$intent->client_secret}} value="@lang('Add Comment')" type="submit">
                            </p>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe("{{env('STRIPE_KEY')}}");

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardElement.addEventListener('change', function (event){
            const displayError = document.getElementById('card-errors')
            if(event.error)
            {
                displayError.textContent=event.error.message;
            }else{
                displayError.textContent='';
            }
        });
        //Handle form submission
        const paymentForm = document.getElementById('payment-form');
        paymentForm.addEventListener('submit', function (event){
            event.preventDefault();

            stripe.handleCardSetup(clientSecret, cardElement, {
                payment_method_data: {
                    billing_details: { name: cardHolderName.value }
                }
            })
            .then(function(result){
                if(result.error)
                {
                    const errorElement = document.getElementById('card-errors')
                    errorElement.textContent = result.error.message;
                }else{
                    const paymentMethodInput = document.getElementByid('payment-method');
                    paymentMethodInput.value = result.setupIntent.payment_method;
                    paymentForm.submit();
                }
            })

        });
        /*cardButton.addEventListener('click', async (e) => {
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );
            const displayError = document.getElementById('card-errors')

            if (error) {
                displayError.textContent=error.message;
            } else {
                displayError.textContent='';
            }
        });*/
    </script>
@endsection

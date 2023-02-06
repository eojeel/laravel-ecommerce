# Laravel Ecommerce
Ecommerce application built with Laravel, Inertia.js, Vue.js, Tailwind.css <br>


# Stripe Payment Testing (https://stripe.com/docs/stripe-cli)
docker run --rm -it stripe/stripe-cli:latest
Webook Testing: https://dashboard.stripe.com/test/webhooks/create?endpoint_location=local
Listener: "docker run -itd --name listner -stripe/stripe-cli:latest listen --forward-to {container IP}/webhook/stripe" && docker logs -f listner

## Todo (Want to completes)
1. profile update re submit flash message


{$order|k}

<div class="block">
    <div class="grid grid--bp-med-2-col">
        <div class="grid__item">
            <h2>Persoonlijke gegevens</h2>
            {$customer = $order->getCustomer()}
            <h3>{$customer->getName()}</h3>

        </div>

    </div>
</div>

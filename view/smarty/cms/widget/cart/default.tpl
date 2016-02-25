{include 'base/form.prototype'}

<div class="block cart js-cart">
    <div class="js-cart"></div>
</div>

<script type="text/template" id="template-cart">
    <table class="table">
        <thead>
            <tr>
                <th width="24">&nbsp;</th>
                <th>{translate key="label.product"}</th>
                <th class="text--center" width="75">{translate key="label.amount"}</th>
                <th class="text--right" width="150">{translate key="label.price"}</th>
                <th class="text--right" width="150">{translate key="label.total"}</th>
            </tr>
        </thead>
        <tbody class="js-cart-body"></tbody>
        <tfoot>
            <tr>
                <td class="text--right" colspan="4"><strong>{translate key="label.total"}</strong></td>
                <td class="text--right"><strong>&euro; <span class="js-cart-total"></span></strong></td>
            </tr>
        </tfoot>
    </table>
    <form id="{$form->getId()}" class="form" action="{$app.url.request}" method="POST" role="form">
        {call formRows form=$form}
        <div class="text--right">
            <button type="submit" class="btn btn--ext">{translate key="label.order"}</button>
        </div>
    </form>
</script>
<script type="text/template" id="template-cart-row">
    <tr>
        <td>
            <a href="#" data-id="<%- orderID %>" class="js-cart-remove"><svg class="icon" viewBox="0 0 24 24"><path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" /></svg></a>
        </td>
        <td><%= title %><span class="cart__variant"><%= variant %></span></td>
        <td class="text--center"><input type="text" class="form__text js-cart-update" data-orderitem="<%- orderID %>" name="amount" inputmode="number" value="<%- amount %>"></td>
        <td class="text--right">&euro; <%= price %></td>
        <td class="text--right">&euro; <%= priceTotal %></td>
    </tr>
</script>
<script type="text/template" id="template-cart-empty">
    <p>{translate key="label.cart.empty"} <a class="link--ext" href="{url id="cms.front.`$app.cms.node->getRootNodeId()`.shop.`$app.locale`"}">{translate key="label.shop.visit"}</a></p>
</script>

{include file="base/form.prototype"}

{addSectionClasses classes="text--center"}
{* {addBodyComponent component="product"} *}

{$images = (isset($content->data->images)) ? $content->data->getImages() : null}
{$variants = (isset($content->data->variants)) ? $content->data->getVariants() : null}
{$variantOptions = (isset($content->data->variants)) ? $content->data->getVariantOptions() : null}
{$price = (isset($content->data->price)) ? $content->data->getPriceWithVAT() : null}
<div class="block">
    {* {$content|k} *}
    {* {if $content->image}
        <div class="image">
            <img src="{image src=$content->image width=125 height=125 transformation="resize"}" />
        </div>
    {/if} *}

    <div class="grid grid--centered">
        {if $images}
            {$firstImage = $images|array_shift}
            <div class="grid__12 grid--bp-med__6">
                <a rel="album" href="{image src=$firstImage->image width=1000 height=1000 transformation="resize"}" class="colorbox spacer--xsm">
                    <img src="{asset style="large-square" src=$firstImage}" class="image image--full-width" alt="">
                </a>
                <div class="spacer--xsm grid grid--3-col{*  grid--bp-med-6-col *}">
                    {foreach $images as $image}
                        <div class="grid__item">
                            <a rel="album" href="{image src=$image->image width=1000 height=1000 transformation="resize"}" class="colorbox">
                                <img src="{asset style="small-square" src=$image}" class="image image--full-width" alt="">
                            </a>
                        </div>
                    {/foreach}
                </div>
            </div>
        {/if}
        <div class="grid__12 grid--bp-med__6">
            <h1>{$content->title}</h1>
            {$content->teaser}
            <div class="form" data-parsley-validate>
                {* {foreach $variantOptions as $variant => $values}
                    <h4>{translate key="label.`$variant`"}</h4>
                    <div class="{$formRowClass} {$formRowClass}--variants {$formRowClass}--variant-{$variant}">
                        <div class="{$formItemClass}">
                            {foreach $values as $id => $value}
                                <div class="{$formElementClass} {$formElementClass}--option">
                                    <input type="radio" required class="js-variants {$formRadioClass}" value="{$id}" name="{$variant}" id="{$variant}-{$id}" />
                                    <label class="{$formLabelClass} {$formLabelClass}--option" for="{$variant}-{$id}">
                                        {$value}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                {/foreach} *}
                <div class="{$formRowClass}">
                    {if $variants}
                        <div class="{$formItemClass}">
                            <div class="{$formElementClass}">
                                <i class="form__icon form__icon--select" aria-hidden="true"></i>
                                <select name="variant" class="{$formSelectClass}" id="variant-{$content->data->getId()}" required>
                                    <option value="">{translate key="label.variant.choose"}</option>
                                    {foreach $variants as $id => $variant}
                                        <option value="{$variant->getId()}">{$variant->getTitle()}</option>
                                        {* {$variant->getTitle()} *}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    {/if}
                    <div class="{$formItemClass} {$formItemClass}--xxs">
                        <div class="{$formElementClass}">
                            <label class="{$formLabelClass} visuallyhidden" for="amount-{$content->data->getId()}">{translate key="label.amount"}</label>
                            <input type="text" inputmode="numeric" class="{$formTextClass}" value="1" id="amount-{$content->data->getId()}" name="amount-{$content->data->getId()}" required />
                        </div>
                    </div>
                    <div class="{$formActionClass}">
                        <button class="btn form__btn js-cart-add" data-variantfield="#variant-{$content->data->getId()}" data-amountfield="#amount-{$content->data->getId()}" data-id="{$content->data->getId()}">{translate key="label.cart.add"}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

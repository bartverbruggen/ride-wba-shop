<?php

namespace ride\controller\widget;

use ride\library\orm\OrmManager;
use ride\library\router\Route;

use ride\web\base\service\TemplateService;
use ride\web\cms\controller\widget\AbstractWidget;

class CartWidget extends AbstractWidget {

    const NAME = 'shop.cart';

    const ICON = 'img/cms/widget/cart.png';

    const TEMPLATE_NAMESPACE = 'cms/widget/cart';

    /**
     * Gets the routes for this widget
     * @return array
     */
    public function getRoutes() {
        return array(
            new Route('/account', array($this, 'accountAction'), 'shop.cart.account'),
            new Route('/overzicht', array($this, 'overviewAction'), 'shop.cart.overview'),
        );
    }

    public function indexAction(OrmManager $om) {
        $locale = $this->getLocale();

        $orderModel = $om->getOrderModel();
        $orderItemModel = $om->getOrderItemModel();
        $orderEntry = $orderModel->createEntry();

        //$orderItemModel

        $translator = $this->getTranslator();

        $form = $this->createFormBuilder($orderEntry);
        // $form->setAction('mail-survey-evaluation');
        $form->addRow('order', 'hidden', array(
            'default' => $this->request->getCookie('__order'),
            'validators' => array(
                'required' => array(),
            ),
        ));
        $form = $form->build();

        if ($form->isSubmitted()) {
            try {
                $form->validate();

                $orderEntry = $form->getData();

                $orderItems = json_decode(urldecode($orderEntry->order));
                $products = [];
                foreach ($orderItems as $orderItem) {
                    $productName = '';
                    $orderItemEntry = $orderItemModel->createEntry();

                    // Find product and add to product name
                    $product = $om->getProductModel()->getBy(array('filter' => array('id' => $orderItem->id)));
                    $productName .= $product->getTitle();
                    $orderItemEntry->setProduct($product);

                    // Amount
                    $orderItemEntry->setAmount($orderItem->amount);

                    // Variants
                    if (isset($orderItem->variant)) {
                        $productVariant = $om->getProductVariantModel()->getBy(array('filter' => array('id' => $orderItem->variant->id)));
                        $orderItemEntry->setVariant($productVariant);
                    }
                    $orderItemModel->save($orderItemEntry);

                    $products[] = $orderItemEntry;
                }

                $orderEntry->setItems($products);
                $orderModel->save($orderEntry);

                $url = $this->getUrl('shop.cart.account');
                $url .= '?'.strtolower($this->getTranslator()->getTranslation('query.order')).'=' . $orderEntry->getId();
                $this->response->setRedirect($url);

                return;
            } catch (ValidationException $exception) {
                $this->setValidationException($exception, $form);
            }
        }

        $view = $this->setTemplateView($this->getTemplate(self::TEMPLATE_NAMESPACE . '/default'), array(
            'entry' => $orderEntry,
            'form' => $form->getView(),
        ));
    }

    public function accountAction(OrmManager $om) {
        // check user
        $user = $this->getUser();
        if ($user) {
            $orderModel = $om->getOrderModel();
            $customerModel = $om->getCustomerModel();
            $orderEntry = $orderModel->getById($this->request->getQueryParameter(strtolower($this->getTranslator()->getTranslation('query.order'))));

            $customerEntry = $customerModel->find(array('filter' => array('user' => $user)));
            if (!$customerEntry) {
                $customerEntry = $customerModel->createEntry();
                $customerEntry->setName($user->getName());
                $customerEntry->setUser($user);

                $customerModel->save($customerEntry);
            } else {
                $customerEntry = reset($customerEntry);
            }

            $orderEntry->setCustomer($customerEntry);
            $orderModel->save($orderEntry);

            $url = $this->getUrl('shop.cart.overview');
            $url .= '?'.strtolower($this->getTranslator()->getTranslation('query.order')).'=' . $orderEntry->getId();
            $this->response->setRedirect($url);
        }

        $view = $this->setTemplateView($this->getTemplate(self::TEMPLATE_NAMESPACE . '/account'), array(
            // 'form' => $form->getView(),
        ));
    }

    public function overviewAction(OrmManager $om) {
        $orderModel = $om->getOrderModel();
        $orderEntry = $orderModel->getById($this->request->getQueryParameter(strtolower($this->getTranslator()->getTranslation('query.order'))));
        $view = $this->setTemplateView($this->getTemplate(self::TEMPLATE_NAMESPACE . '/overview'), array(
            'order' => $orderEntry,
        ));
    }


}

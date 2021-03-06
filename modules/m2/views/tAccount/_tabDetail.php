<!--
<h2>Parent Account</h2>
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Parent Account',
            'type' => 'raw',
            'value' => isset($model->getparent->account_name) ? CHtml::link($model->getparent->account_no . ". " . $model->getparent->account_name, Yii::app()->createUrl('/m2/tAccount/view', array('id' => $model->parent_id))) : "::root::",
        ),
        'short_description',
    ),
));
?>

<br />
-->
<h3>Account Properties</h3>

<?php
//$this->widget('bootstrap.widgets.TbDetailView', array(
$this->widget('ext.XDetailView', array(
    'ItemColumns' => 2,
    'data' => array(
        'id' => 1,
        'account_type' => $model->getRoot(),
        'currency' => $model->getCurrency(),
        'state' => $model->getState(),
        'has_child' => $model->getHaschildIsInherited(),
        'parent_account' => (isset($model->getparent)) ? $model->getparent->account_concat : "ROOT",
        'cash_bank' => (isset($model->cashbank)) ? $model->cashbank->mvalue : "Not Set",
        'cash_bank_code' => (isset($model->cashbankCode)) ? $model->cashbankCode->mvalue : "Not Set",
        'hutang' => (isset($model->hutang)) ? $model->hutang->setMvalue() : "Not Set",
        'inventory' => (isset($model->inventory)) ? $model->inventory->setMvalue() : "Not Set",
    ),
    'attributes' => array(
        array('name' => 'account_type', 'label' => 'Account Type'),
        array('name' => 'currency', 'label' => 'Currency'),
        array('name' => 'state', 'label' => 'Status'),
        array('name' => 'has_child', 'label' => 'Has Child'),
        array('name' => 'parent_account', 'label' => 'Parent Account'),
        array('name' => 'cash_bank', 'label' => 'Cash Bank Account', 'visible' => (isset($model->cashbank))),
        array('name' => 'cash_bank_code', 'label' => 'Cash Bank Code', 'visible' => (isset($model->cashbankCode))),
        array('name' => 'hutang', 'label' => 'Payable Account', 'visible' => (isset($model->hutang))),
        array('name' => 'inventory', 'label' => 'Inventory Account', 'visible' => (isset($model->inventory))),
    ),
));
?>



<?php
if ($model->haschild) {
    ?>

    <hr />

    <h3>Child Account</h3>
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 't-account-grid',
        'dataProvider' => tAccount::model()->search($model->id),
        'itemsCssClass' => 'table table-striped table-bordered',
        'template' => '{items}{pager}',
        'columns' => array(
            array(
                'name' => 'account_no',
                'type' => 'raw',
                'value' => 'CHtml::link($data->account_concat,Yii::app()->createUrl("/m2/tAccount/view",array("id"=>$data->id)))',
            ),
            array(
                'name' => 'haschild_id',
                'value' => '$data->getHaschildIsInherited()',
            ),
            array(
                'header' => 'Account Type',
                'value' => '$data->getRoot()',
            ),
            array(
                'header' => 'Currency',
                'value' => '$data->getCurrency()',
            ),
            array(
                'header' => 'Status',
                'value' => '$data->getState()',
            ),
        ),
    ));
    ?>

    <?php
}
?>

<hr />

<h3>Sibling Account</h3>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 't-account-grid',
    'dataProvider' => tAccount::model()->searchSibling($model->parent_id, $model->id),
    'itemsCssClass' => 'table table-striped table-bordered',
    'template' => '{items}{pager}',
    'columns' => array(
        array(
            'name' => 'account_no',
            'type' => 'raw',
            'value' => 'CHtml::link($data->account_no. ". ".$data->account_name,Yii::app()->createUrl("/m2/tAccount/view",array("id"=>$data->id)))',
        ),
        array(
            'name' => 'haschild_id',
            'value' => '$data->haschildIsInherited',
        ),
        array(
            'header' => 'Type Account',
            'value' => '$data->getRoot()',
        ),
        array(
            'header' => 'Currency',
            'value' => '$data->getCurrency()',
        ),
        array(
            'header' => 'Status',
            'value' => '$data->getState()',
        ),
    ),
));
?>

<?php
if ($model->haschild) {
    ?>

    <hr />

    <h3>New Account</h3>
    <?php echo $this->renderPartial('_form', array('model' => $modelAccount)); ?>

    <?php
}
?>





<?php
/**
# WHMCS Instamojo Module - Developed by Shiv Singh
# Author: Shiv Singh
# Email: shivsingh7150@hotmail.com
# Website: https://www.facebook.com/joinshiv
# Version: 1.1
**/

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function instamojo_MetaData()
{
    return array(
        'DisplayName' => 'Instamojo',
        'APIVersion' => '1.1', // API Version 1.1
        'DisableLocalCredtCardInput' => true,
        'TokenisedStorage' => false,
    );
}

function instamojo_config()
{
    return array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Instamojo Gateway',
        ),
        'privateapikey' => array(
            'FriendlyName' => 'Private API Key',
            'Type' => 'text',
            'Size' => '50',
            'Default' => '',
            'Description' => 'Enter Private API Key',
        ),
        'privateauthtoken' => array(
            'FriendlyName' => 'Private Auth Token',
            'Type' => 'text',
            'Size' => '50',
            'Default' => '',
            'Description' => 'Enter Private Auth Token',
        ),
		'privatesalt' => array(
            'FriendlyName' => 'Private Salt',
            'Type' => 'text',
            'Size' => '50',
            'Default' => '',
            'Description' => 'Enter Private Salt',
        ),
		  'send_email' => array(
            'FriendlyName' => 'Send Email',
            'Type' => 'dropdown',
            'Options' => array(
                'True' => 'Yes',
                'False' => 'No',
            ),
            'Description' => 'Send Mail From Instamojo',
        ),
        'transferinstructions' => array(
            'FriendlyName' => 'Transfer Instructions',
            'Type' => 'textarea',
            'Rows' => '3',
            'Cols' => '60',
            'Description' => 'Transfer Instructions',
        ),
    );
}
function instamojo_link($instamojo_params)
{
    // Gateway Configuration Parameters
    $privateapikey = $instamojo_params['privateapikey'];
    $privateauthtoken = $instamojo_params['privateauthtoken'];
	$privatesalt = $instamojo_params['privatesalt'];
    $send_email = $instamojo_params['send_email'];
	$transferinstructions = $instamojo_params['transferinstructions'];
	
    // Invoice Parameters
    $invoiceId = $instamojo_params['invoiceid'];
    $description = $instamojo_params["description"];
    $amount = $instamojo_params['amount'];
    $currencyCode = $instamojo_params['currency'];

    // Client Parameters
    $firstname = $instamojo_params['clientdetails']['firstname'];
    $lastname = $instamojo_params['clientdetails']['lastname'];
    $email = $instamojo_params['clientdetails']['email'];
    $address1 = $instamojo_params['clientdetails']['address1'];
    $address2 = $instamojo_params['clientdetails']['address2'];
    $city = $instamojo_params['clientdetails']['city'];
    $state = $instamojo_params['clientdetails']['state'];
    $postcode = $instamojo_params['clientdetails']['postcode'];
    $country = $instamojo_params['clientdetails']['country'];
    $phone = $instamojo_params['clientdetails']['phonenumber'];

    // System Parameters
    $companyName = $instamojo_params['companyname'];
    $systemUrl = $instamojo_params['systemurl'];
    $returnUrl = $instamojo_params['returnurl'];
    $langPayNow = $instamojo_params['langpaynow'];
    $moduleDisplayName = $instamojo_params['name'];
    $moduleName = $instamojo_params['paymentmethod'];
    $whmcsVersion = $instamojo_params['whmcsVersion'];

    $postfields = array();
    $postfields['username'] = $username;
    $postfields['invoice_id'] = $invoiceId;
    $postfields['description'] = $description;
    $postfields['amount'] = $amount;
    $postfields['currency'] = $currencyCode;
    $postfields['first_name'] = $firstname;
    $postfields['last_name'] = $lastname;
    $postfields['email'] = $email;
    $postfields['address1'] = $address1;
    $postfields['address2'] = $address2;
    $postfields['city'] = $city;
    $postfields['state'] = $state;
    $postfields['postcode'] = $postcode;
    $postfields['country'] = $country;
    $postfields['phone'] = $phone;
    $postfields['callback_url'] = $systemUrl . '/modules/gateways/callback/' . $moduleName . '.php';
    $postfields['return_url'] = $returnUrl;

    $htmlOutput = '<p>'.$transferinstructions.'</p><form method="post" name="checkout" action="'.$systemUrl.'/modules/gateways/'.$moduleName.'/RequestHandler.php">';
    foreach ($postfields as $k => $v) {
        $htmlOutput .= '<input type="hidden" name="' . $k . '" value="' . $v . '" />';
    }
    $htmlOutput .= '<input type="submit" value="' . $langPayNow . '" />';
    $htmlOutput .= '</form>';

    return $htmlOutput;
}
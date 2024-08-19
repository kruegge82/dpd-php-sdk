<?php 

require_once 'vendor/autoload.php';
    
use kruegge82\DPDAuthorisation;
use kruegge82\DPDShipment;

try{
    
    // Second parameter to disable the wsdl cache defaults to true
    $authorisation = new DPDAuthorisation([
        'staging' => true,
        'delisId' => '...',
        'password' => '...',
        'messageLanguage' => 'de_DE', // en_EN
        'customerNumber' => '...'
    ]);
    
    // Second parameter to disable the wsdl cache defaults to true
    // $authorisation = new DPDAuthorisation($dpd, false);
    
    // Init the shipment with authorisation
    $shipment = new DPDShipment($authorisation);
    
    // Second parameter to disable the wsdl cache defaults to true
    // $shipment = new DPDShipment($authorisation, false);

    // Set the language for the track&trace link
    $shipment->setTrackingLanguage('de_DE');

    // Enable saturday delivery
    $shipment->setSaturdayDelivery(false);

    // Enable DPD B2C delivery method
    $shipment->setPredict([
        'channel' => 'email',
        'value' => 'someone@mail.com',
        'language' => 'EN'
    ]);

    // Set the general shipmentdata
    $shipment->setGeneralShipmentData([
        'product' => 'CL',
        'mpsCustomerReferenceNumber1' => 'Test shipment'
    ]);

    // Set the printer options
    $shipment->setPrintOptions([
        'printerLanguage' => 'PDF',  // ZPL
        'paperFormat' => 'A6',
    ]);     

    // Set the sender's address
    $shipment->setSender([
        'name1' => 'Your Company',
        'street' => 'Street 12',
        'country' => 'DE',
        'zipCode' => '12345',
        'city' => 'Berlin',
        'email' => 'contact@yourcompany.com',
        'phone' => '1234567645'
    ]);

    // Set the receiver's address
    $shipment->setReceiver([
        'name1' => 'Joh Doe',         
        'name2' => null,       
        'street' => 'Street',       
        'houseNo' => '12',    
        'zipCode' => '98765',
        'city' => 'München',
        'country' => 'DE',
        'contact' => null,        
        'phone' => null,                 
        'email' => null,             
        'comment' => null 
    ]);

    // Add as many parcels as you want
    $shipment->addParcel([
        'weight' => 3000, // In gram
        'height' => 10, // In centimeters
        'width' => 10,
        'length' => 10
    ]);

    $shipment->addParcel([
        'weight' => 5000,
        'height' => 20,
        'width' => 30,
        'length' => 20
    ]);

    // Submit the shipment
    $shipment->submit();

    // Get the trackingdata
    $trackinglinks = $shipment->getParcelResponses();

    // Show the pdf label
    header('Content-Type: application/pdf');
    echo $shipment->getLabels();


}catch(Exception $e){
    dump($e->getMessage());		
}



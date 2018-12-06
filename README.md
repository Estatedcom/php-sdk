Estated PHP Library
=========================

This is a PHP Library for easily integrating v3 of the Estated API into your application. 

* Details about Estated's API: [https://estated.com/developers/docs](https://estated.com/developers/docs)

Library Requirements
--------------------

* PHP 7.1 and above.

Getting Started
=====================

## Step 1:  API Key
First and foremost, you need an API key from Estated.  Without this you won't get too far.  If you already have an account with Estated, you can find your key under the API Keys section of the dashboard.  If you need a key, [create an account](https://estated.com/developers/register) to have one assigned to you.

## Step 2:  Pick a Request Type
There are 5 different ways to request a property and we will go over each so you can start requesting properties with ease:

### 1. Conforming Request
The below example lists the minimum values that need to be supplied in the constructor for a valid Conforming Request.  Other optional parameters you can add to the associative array supplied to the constructor are: 'zipcode' and 'format'. 

```php
$request = new Estated\Requests\ConformingRequest([
    'token' => 'YourApiKeyGoesHere',
    'address' => '1716 Heritage Cir',
    'city' => 'Anaheim',
    'state' => 'CA'
]);
```

### 2. Fully Qualified Request
The below example lists the minimum values that need to be supplied in the constructor for a valid Fully Qualified Request. 
Other optional parameters you can add to the associative array supplied to the constructor are: 'unit_number', 'street_direction', 'zipcode' and 'format'.

```php
$request = new Estated\Requests\FullyQualifiedRequest([
    'token' => 'YourApiKeyGoesHere',
    'street_number' => 220,
    'street_name' => 'Rodeo',
    'street_suffix' => 'Dr',
    'city' => 'Beverly Hills',
    'state' => 'CA'
]);
```

### 3. Conjoined Request
The below example lists the minimum values that need to be supplied in the constructor for a valid Conjoined Request. Other optional parameters you can add to the associative array supplied to the constructor are: 'unit_number' and 'format'.

```php
$request = new Estated\Requests\ConjoinedRequest([
    'token' => 'YourApiKeyGoesHere',
    'street_number' => '220',
    'street_name' => 'Rodeo',
    'street_suffix' => 'Dr',
    'city' => 'Beverly Hills',
    'state' => 'CA',
    'zipcode' => '90212'
]);
```

### 4. FIPS & APN Request
The below example lists the minimum values that need to be supplied in the constructor for a valid FIPS & APN Request.  Other optional parameters you can add to the associative array supplied to the constructor are: 'format'.

```php
$request = new Estated\Requests\ApnFipsRequest([
    'token' => 'YourApiKeyGoesHere',
    'apn' => '4328-031-029',
    'fips' => '06037'
]);
```

### 5. UPI Request
The below example lists the minimum values that need to be supplied in the constructor for a valid UPI Request.  Other optional parameters you can add to the associative array supplied to the constructor are: 'format'.

```php
$request = new Estated\Requests\UpiRequest([
    'token' => 'YourApiKeyGoesHere',
    'upi' => 'US-06059-N-12856338-R-N',
]);
```

If you require more information on these request types, visit our [Request Overview](https://estated.com/developers/docs/v3/property/overview#request) page for more details.

## Step 3:  Send Your Request
You've built a valid request, now send it. 

```php
$response = $request->send();
```

* For further information: [http://estated.com/developers/docs/](http://estated.com/developers/docs)

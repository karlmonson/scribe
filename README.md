Scribe
=================

The Unofficial PHP Sendy API Wrapper ([http://sendy.co](http://sendy.co))

### Installation

* Place Scribe.php into your file structure
* Include or require Scribe in the location you would like to utilize it

```php
  require('lib/Scribe.php');
```

#Usage

Create an instance of the class while passing in an array including your Instance URL, API Key, and the List ID you wish to work with.
```php

  $config = array(
      'instance' => 'http://example.com/sendy',  //Your Sendy installation
      'api_key' => 'your_api_key', //your API key is available in Settings
      'list_id' => 'your_list_id'
  );

  $scribe = new Scribe($config);

  //you can change the list_id you are referring to at any point
  $scribe->setListId('new_list_id');
```

#Methods
After creating a new instance of Scribe call any of the methods below

##Return Values
The return value of any of these functions will include both a status, and a message to go with that status.

The status is a string value of `success` or `error` and the message will vary based on the type of action being performed.

```php
  //example of a succesful return value
  array(
    'status' => 'success',
    'message' => 'Subscribed'
  )

  //example of an unsuccesful return value
  array(
    'status' => 'error',
    'message' => 'Already subscribed'
  )
```

##subscribe(array $values)

This method takes an array of `$values` and will attempt to add the `$values` into the list specified in `$list_id`

```php
  $results = $scribe->subscribe(array(
            'name' => 'John Doe',
            'email' => 'jdoe@example.com', //this is the only field required by sendy
            'birthday' => '01/01/1990'
            ));
```
__PS:__ Be sure to add any custom fields to the list in Sendy before utilizing them inside this library.
__PPS:__ If a user is already subscribed to the list, the library will return a status of `true`.

##unsubscribe($email)

Unsubscribes the provided e-mail address (if it exists) from the current list.
```php
  $results = $scribe->unsubscribe('jdoe@example.com');
```

##subscriptionStatus($email)

Returns the status of the user with the provided e-mail address (if it exists) in the current list.
```php
  $results = $scribe->subscriptionStatus('jdoe@example.com');
```
__PS:__ refer to http://sendy.co/api for the types of return messages you can expect.

##activeSubscriberCount()

Returns the number of subscribers to the current list.
```php
  $results = $scribe->activeSubscriberCount();
```

##setListId($list_id) and getListId()

Change or get the list you are currently working with.
```php

  //set or switch the list id
  $scribe->setListId('new_list_id');

  //get the current list id
  echo $scribe->getListId();
```
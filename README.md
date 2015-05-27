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
  $scribe->set_list_id('new_list_id');
```

#Methods
After creating a new instance of Scribe call any of the methods below

##Return Values
The return value of any of these functions will include both a status, and a message to go with that status.

The status is a boolean value of `true` or `false` and the message will vary based on the type of action being performed.

```php
  //example of a succesful return value
  array(
    'status' => 'success',
    'message' => 'jdoe@example.com subscribed'
  )

  //example of an unsuccesful return value
  array(
    'status' => 'error',
    'message' => 'jdoe@example.com already subscribed'
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

##subscription_status($email)

Returns the status of the user with the provided e-mail address (if it exists) in the current list.
```php
  $results = $scribe->subscription_status('jdoe@example.com');
```
__PS:__ refer to http://sendy.co/api for the types of return messages you can expect.

##active_subscriber_count()

Returns the number of subscribers to the current list.
```php
  $results = $scribe->active_subscriber_count();
```

##set_list_id($list_id) and get_list_id()

Change or get the list you are currently working with.
```php

  //set or switch the list id
  $scribe->set_list_id('new_list_id');

  //get the current list id
  echo $scribe->get_list_id();
```
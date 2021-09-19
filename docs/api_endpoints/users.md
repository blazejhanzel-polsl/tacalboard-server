# GET

## /{id}/confirm/{key}
Confirm registration of users specified in {id} if {key} is valid with key in database.

### Returns
- **200**
- **404** not-found
- **409** data-not-equal

## /authorize
Send information about currently logged user.

### Returns
- **200**
```
{
    "id": "x"
}
```
- **401** authorization-not-logged

# POST

## /
Registers new user with provided info.
```
{
    "email": "x",
    "password": "sha1(x)"
}
```

### Returns
- **200**
- **400** insufficient-content
- **409** unique-already-used

## /authorize
Provides functionality to login selected user in to session.

Needs formatted json to proceed.
```
{
    "email": "x",
    "password": "sha1(x)"
}
```

### Returns
- **401** authorization-wrong-password
- **404** not-found

# PUT
Change user credentials after checking if password in provided json is valid with saved in database.
```
{
    "id": "x",
    "email": "x",
    ... all columns of users ...
}
```

### Returns
- **200**
- **400** insufficient-content
- **401** authorization-not-logged
- **401** authorization-rejected
- **404** not-found

# PATCH
Change users password if old is valid with saved in database.
```
{
    "password_old": "x",
    "password_new": "y"
}
```

### Returns 
- **200**
- **400** insufficient-content
- **401** authorization-rejected

# DELETE

## /authorize
Ends session and logout currently logged user.

Needs no body.

### Returns
- **204** no-content
- **401** authorization-not-logged

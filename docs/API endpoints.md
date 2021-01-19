Contains information about all endpoints in API. Ordered alphabetically.

# /projects

## GET
Provide information about projects in which currently logged user is an owner or member.

### Returns
- **200**
```
{
    "ids": [1, 2, ...]
}
```
- **401** authorization-not-logged

## POST
Creates new project with provided informations.
```
{
    "team_id": "x",
    "name": "x",
    ... all columns without id from projects table ...
}
```

### Returns
- **201** created
- **400** insufficient-content
- **401** authorization-not-logged

## PUT
Updates project indatabse using provided data.
```
{
    "id": "x",
    "team_id": "x",
    ... all columns from projects table ...
}
```

### Returns
- **200**
- **400** insufficient-content
- **401** authorization-not-logged
- **403** insufficient-privileges
- **404** not-found

# /projects/{id}

## GET
Provide informations about selected project

### Returns
- **200**
```
{
    "id": "x",
    ... all columns from projects table ...
}
```
- **401** authorization-not-logged
- **404** not-found

## DELETE
Deletes selected project if currently logged user is an owner.

### Returns
- **200**
- **401** authorization-not-logged
- **403** insufficient-privileges
- **404** not-found

# /tasks_lists/byProject/{id}

## GET
Get all tasks lists which belongs to provided project.

### Returns
- **200**
```
{
    "ids": [1, 2, ...]
}
```
- **401** authorization-not-logged
- **404** not-found

## POST
Adds new task list into provided project using data provided in json body.
```
{
    ... all columns from tasks_lists table without id ...
}
```

### Returns 
- **201** created
- **400** insufficient-content
- **401** authorization-not-logged
- **404** not-found

# /teams

## GET
Provide information about teams, to which current user belongs.

### Returns
- **200**
```
{
    "ids": [1, 2, ...]
}
```
- **401** authorization-not-logged

## POST
Creates new team with provided informations and sets currently logged user as owner.

Needs formatted json to proceed.
```
{
    "name": "x"
}
```

### Returns 
- **200**
- **400** insufficient-content
- **401** authorization-not-logged

## PUT
Updates team in database using informations provided by json.
```
{
    "id": "x",
    "name": "x",
    ... all columns from teams table ...
}
```

### Returns
- **200**
- **401** authorization-not-logged
- **403** insufficient-privileges

# /teams/{id}

## GET
Provide information about selected team.

### Returns
- **200**
```
{
    "id": "x",
    "name": "x",
    "role": "x"
}
```
- **401** authorization-not-logged
- **403** insufficient-privileges

## DELETE
Deletes selected team if currently logged user has privileges to do that.

### Returns
- **200**
- **401** authorization-not-logged
- **403** insufficient-privileges

# /users

## POST
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


## PUT
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
- **401** authorization-rejected

## PATCH
Change users password if old is valid with saved in database.
```
{
    "password_old": "x",
    "password_new: "y"
}
```

### Returns 
- **200**
- **400** insufficient-content
- **401** authorization-rejected

# /users/{id}/confirm/{key}

## GET
Confirm registration of users specified in {id} if {key} is valid with key in database.

### Returns
- **200**
- **409** data-not-equal

# /users/authorize

## GET
Send information about currently logged user.

### Returns
- **200**
```
{
    "id": "x",
    "email": "x",
    ... all columns without password ...
}
```
- **401** authorization-not-logged

## POST
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

## DELETE
Ends session and logout currently logged user.

Needs no body.

### Returns
- **200**

Contains information about all endpoints in API. Ordered alphabetically.

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


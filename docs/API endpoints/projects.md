# GET

## /
Provide information about projects in which currently logged user is an owner or member.

### Returns
- **200**
```
[
    {
        "team_id": "x",
        "name": "x",
        ... all columns without id from projects table ...
    },
    ...
]
```
- **401** authorization-not-logged

## /{id}
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

# POST

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
- **403** insufficient-privileges
- **500** database-query-error

# PUT

Updates project indatabse using provided data.
```
{
    "id": "x",
    "team_id": "x",
    ... all columns from projects table ...
}
```

### Returns
- **204** no-content
- **400** insufficient-content
- **401** authorization-not-logged
- **403** insufficient-privileges
- **404** not-found
- **500** database-query-error

# DELETE

## /{id}
Deletes selected project if currently logged user is an owner.

### Returns
- **200**
- **401** authorization-not-logged
- **403** insufficient-privileges
- **404** not-found
- **500** database-query-errort

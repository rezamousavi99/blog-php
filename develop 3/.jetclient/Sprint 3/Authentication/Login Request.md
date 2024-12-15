```toml
name = 'Login Request'
description = '/api/login'
method = 'POST'
url = '{{baseUrl}}/api/login'
sortWeight = 1000000
id = '87564c6a-b692-4587-9578-12a9e3b4b166'

[[headers]]
key = 'Accept'
value = 'application/json'

[auth]
type = 'NO_AUTH'

[[body.formData]]
key = 'user_name'
value = 'reza'

[[body.formData]]
key = 'password'
value = '12345678'
```

### Example

```toml
name = 'Invalid 401'
id = 'f7a454c2-e2b1-4fdc-b1b2-1aa9b16b91e6'

[[headers]]
key = 'Accept'
value = 'application/json'

[[body.formData]]
key = 'user_name'
value = 'reza'

[[body.formData]]
key = 'password'
```

### Example

```toml
name = 'Success 200'
id = 'b68e2dd2-7f1d-455d-b98e-4c27d91adac4'

[[headers]]
key = 'Accept'
value = 'application/json'

[[body.formData]]
key = 'user_name'
value = 'reza'

[[body.formData]]
key = 'password'
value = '12345678'
```

### Example

```toml
name = 'validation 422'
id = 'd0c7c910-c8d2-4e9b-b352-c20b7f9b7bfb'

[[headers]]
key = 'Accept'
value = 'application/json'

[[body.formData]]
key = 'user_name'
value = 'sina'

[[body.formData]]
key = 'password'
```

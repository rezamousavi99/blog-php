```toml
name = 'Register Request'
description = '/api/register'
method = 'POST'
url = '{{baseUrl}}/api/register'
sortWeight = 2000000
id = 'e1d97eb2-f604-4183-b5d9-ee42e488f4d2'

[[headers]]
key = 'Accept'
value = 'application/json'

[[body.formData]]
key = 'user_name'
value = 'reza'

[[body.formData]]
key = 'email'
value = 'reza@df.com'

[[body.formData]]
key = 'password'
value = '12345678'
```

### Example

```toml
name = 'Validation Error 422'
id = 'ae27e14f-b7e5-40db-84d4-9ff587d583a7'

[[headers]]
key = 'Accept'
value = 'application/json'

[[headers]]
key = 'Content-Type'
value = 'application/json'

[[body.formData]]
key = 'user_name'
value = 'reza'

[[body.formData]]
key = 'email'
value = 'reza@df.com'

[[body.formData]]
key = 'password'
value = '1234'
```

### Example

```toml
name = 'Success 200'
id = 'e88f6a13-424e-402a-b81c-f8d237056e5c'

[[headers]]
key = 'Accept'
value = 'application/json'

[[body.formData]]
key = 'user_name'
value = 'reza'

[[body.formData]]
key = 'email'
value = 'reza@df.com'

[[body.formData]]
key = 'password'
value = '12345678'
```

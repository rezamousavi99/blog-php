```toml
name = 'Update'
description = '/api/update-post/6'
method = 'PUT'
url = '{{baseUrl}}/api/update-post/6'
sortWeight = 2000000
id = '1293c14f-f40c-4320-9775-d64aa5f57008'

[[headers]]
key = 'Accept'
value = 'application/json'

[auth.bearer]
token = '2|b0uB8d6xoFRKds9Obc0oIMVW4T80rwTheVBF7uGnd4d28e7b'

[body]
type = 'JSON'
raw = '''
{
    "title": "sina post update",
    "excerpt": "TESTTT",
    "content": "TESTTTT",
    "tags": ["scorpion", "cat"]
}'''
```

### Example

```toml
name = 'unauthentiacted 401'
id = '61fd2347-2698-4070-b89a-9965fb851e04'

[[headers]]
key = 'Accept'
value = 'application/json'

[body]
type = 'JSON'
raw = '''
{
    "title": "dfdddddddddxcvdddcdd",
    "excerpt": "TESTTT",
    "content": "TESTTTT",
    "tags": ["duck", "test3", "wow"]
}'''
```

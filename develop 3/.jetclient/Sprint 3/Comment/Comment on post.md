```toml
name = 'Comment on post'
description = '/api/post/1/comment'
method = 'POST'
url = '{{baseUrl}}/api/post/1/comment'
sortWeight = 1000000
id = 'ca3e8b84-fc65-4699-a1a2-8d431205f98b'

[auth.bearer]
token = '3|f92ZsGNvaLKQCRKJFMfCLuLTKhRHFJhu9L02LR9n09d90e81'

[body]
type = 'JSON'
raw = '''
{
    "content": "Greate post2"
}'''
```

Module config:
```
'forum' => [
        'namespace' => 'Module\Forum',
        'webControllerNamespace' => 'Module\Forum\Presentation\Web\Controller',
        'apiControllerNamespace' => '',
        'className' => 'Module\Forum\Module',
        'path' => APP_PATH . '/modules/Forum/Module.php',
        'defaultRouting' => true,
        'defaultController' => 'index',
        'defaultAction' => 'index'
    ]
```

## Usecases
mandatory:
- Register
- Login
- Logout

pembagian 1:
- Edit profile
- Kasi cendol

- Create forum (yang nge-create jadi admin forum)
- Join forum
- Leave forum
- Ban user dari forum

pembagian 2:
- Create post
- Create comment di post
- Delete post
- Delete comment
- Vote post
- Vote comment

pembagian 3:
- Sambungin post ke forum
- Feed semua forum
- View post di forum
# Upload de Imagens em PHP

Image type aceitos:

```php
IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF
```

# Installation


```json
"kdesignbrasil/img-upload": "dev-master"
```

# Example

```html
<form action="../src/Upload.php" method="post" enctype="multipart/form-data" >
	<input type="file" name="file[]" multiple>
	<input type="submit">
</form>

```
```php

use UploadLeandro\Upload;

$upload = new upload($_FILES['file']);  
$upload->setSize("TAMANHO ARQUIVO");   
$upload->setDir("DIRETORIO");
$enviar = $upload->startUpload(); 
var_dump($enviar);
```
NGREST FIELD SELECT
====================

### Select Array

Create a dropdown selection based on an assoc array:

```
public function ngrestAttributeTypes()
{
     'genres' => ['selectArray', 'data' => [1 => 'Male', 2 => 'Female']],
}
```

### Select Model

Create a dropdown selection based on an model class:

```
public function ngrestAttributeTypes()
{
     'genres' => ['selectModel', 'modelClass' => path\to\Genres::className(), 'valueField' => 'id', 'labelField' => 'title']],
}
```
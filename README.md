# Notes
___
> Set ACF
```
data-part='navbar'
```
> Attribute for shared blocks.
> 
> Added on the common block - wrapper.
> This part of the layout will be added to the template-parts folder 
> with the name specified in the attribute 
> in this case `navbar.php`.
> in the place where the block was
> will be added 

```php 
<?php get_template_part ( 'template-parts/navbar' ); ?> 
```

---

> For a 404 template, use the slug name `page-not-found` or `404`

---

>To run locally in a terminal
```bash
php -S localhost:9000
```

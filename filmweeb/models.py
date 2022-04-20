from django.db import models

class Movie(models.Model):
    original_title = models.CharField(max_length=100)
    production_year = models.CharField(max_length=4, null=True, blank=True)
    production_country = models.CharField(max_length=50, null=True, blank=True)
    airing_date = models.DateField(null=True, blank=True)
    duration = models.IntegerField(null=True, blank=True)
    description = models.TextField(null=True, blank=True)
    title = models.CharField(max_length=100, null=True, blank=True)

    def __str__(self):
        if self.title is None:
            return self.original_title
        else:
            return self.title
    
class Links(models.Model):
    link_type = models.CharField(max_length=20)
    address = models.URLField(max_length=500)
    movie_id = models.ForeignKey('Movie', on_delete=models.CASCADE)

class User(models.Model):
    email = models.EmailField()
    passwd = models.CharField(max_length=50)
    birth_date = models.DateField()
    nick = models.ForeignKey('Profile',on_delete=models.CASCADE)
    is_admin = models.BooleanField()

class Profile(models.Model):
    first_name = models.CharField(max_length=100, null=True, blank=True)
    last_name = models.CharField(max_length=100, null=True, blank=True)
    user_id = models.ForeignKey('User',on_delete=models.CASCADE)
    avatar = models.URLField(max_length=1000, null=True, blank=True)

class List(models.Model): 
    list_name = models.CharField(max_length=100)
    nick = models.ForeignKey('User',on_delete=models.CASCADE)

class MovieList(models.Model):
    movie_id = models.ForeignKey('Movie',on_delete=models.CASCADE)
    list_id = models.ForeignKey('List',on_delete=models.CASCADE)

class Mark(models.Model):
    mark = models.PositiveSmallIntegerField()
    movie_id = models.ForeignKey('Movie',on_delete=models.CASCADE)
    user_id = models.ForeignKey('User',on_delete=models.CASCADE)

class Comment(models.Model):
    comment = models.TextField()
    movie_id = models.ForeignKey('Movie',on_delete=models.CASCADE)
    review_id = models.ForeignKey('Review', on_delete=models.CASCADE)
    user_id = models.ForeignKey('User',on_delete=models.CASCADE)

class Review(models.Model):
    review = models.TextField()
    review_type = models.CharField(max_length=20)
    creation_date = models.TextField()
    movie_id = models.ForeignKey('Movie',on_delete=models.CASCADE)
    user_id = models.ForeignKey('User',on_delete=models.CASCADE)


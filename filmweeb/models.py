from django.db import models

class Links(models.Model):
    link_type = models.CharField(max_length=20)
    address = models.URLField(max_length=500)
    movie_id = models.ForeignKey(Movie, on_delete=models.CASCADE)
class Movie(models.Model):

class MovieList(models.Model):
    movie_id = models.ForeignKey(Movie,on_delete=models.CASCADE)
    list_id = models.ForeignKey(List,on_delete=models.CASCADE)

class List(models.Model): 
    list_name = models.CharField(max_length=100)
    nick = models.ForeignKey(User,on_delete=models.CASCADE)

class Profile(models.Model):
    first_name = models.CharField(max_length=100)
    last_name = models.CharField(max_length=100)
    user_id = models.ForeignKey(User,on_delete=models.CASCADE)
    avatar = models.URLField(max_length=1000)

class User(models.Model):
    email = models.EmailField(max_field = 255)
    passwd = models.CharField(max_length=50)
    birth_date = models.DateField()
    nick = ForeignKey(Profile,on_delete=models.CASCADE)
    is_admin = models.BooleanField()

class Mark(models.Model):
    mark = models.PositiveSmallIntegerField()
    movie_id = ForeignKey(Movie,on_delete=models.CASCADE)
    user_id = ForeignKey(User,on_delete=models.CASCADE)

class Comment(models.Model):
    comment = models.TextField()
    movie_id = models.ForeignKey(Movie,on_delete=models.CASCADE)
    review_id = models.ForeignKey(Review, on_delete=models.CASCADE)
    user_id = models.ForeignKey(User,on_delete=models.CASCADE)

class Review(models.Model):
    review = models.TextField()
    review_type = CharField(max_length=20)
    creation_date = models.TextField()
    movie_id = models.ForeignKey(Movie,on_delete=models.CASCADE)
    user_id = ForeignKey(User,on_delete=models.CASCADE)
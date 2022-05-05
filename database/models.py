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
    
class User(models.Model):
    email = models.EmailField()
    passwd = models.CharField(max_length=50)
    birth_date = models.DateField()
    is_admin = models.BooleanField()

    def __str__(self):
        return self.email

class Profile(models.Model):
    nick = models.CharField(max_length=32)
    first_name = models.CharField(max_length=100, null=True, blank=True)
    last_name = models.CharField(max_length=100, null=True, blank=True)
    avatar = models.URLField(max_length=1000, null=True, blank=True)
    user = models.OneToOneField("User", on_delete=models.CASCADE)
    def __str__(self):
        return self.nick

class List(models.Model): 
    list_name = models.CharField(max_length=100)
    nick = models.ForeignKey('User',on_delete=models.CASCADE)
    movies = models.ManyToManyField("Movie")
    def __str__(self):
        return self.list_name

#class MovieList(models.Model):
#    movie = models.ForeignKey('Movie',on_delete=models.CASCADE)
#    list = models.ForeignKey('List',on_delete=models.CASCADE)

class MovieMark(models.Model):
    mark = models.PositiveSmallIntegerField()
    movie = models.ForeignKey('Movie',on_delete=models.CASCADE)
    user = models.ForeignKey('User',on_delete=models.CASCADE)
    def __str__(self):
        return self.mark
        
class PersonMark(models.Model):
    mark = models.PositiveSmallIntegerField()
    person = models.ForeignKey('Person',on_delete=models.CASCADE)
    user = models.ForeignKey('User',on_delete=models.CASCADE)
    def __str__(self):
        return self.mark

class MovieComment(models.Model):
    comment = models.TextField()
    movie = models.ForeignKey('Movie',on_delete=models.CASCADE)
    user = models.ForeignKey('User',on_delete=models.CASCADE)
    def __str__(self):
        return self.comment


class ReviewComment(models.Model):
    comment = models.TextField()
    review = models.ForeignKey('Review', on_delete=models.CASCADE)
    user = models.ForeignKey('User',on_delete=models.CASCADE)
    def __str__(self):
        return self.comment

class Review(models.Model):
    review = models.TextField()
    review_type = models.CharField(max_length=20)
    creation_date = models.TextField()
    movie = models.ForeignKey('Movie',on_delete=models.CASCADE)
    user = models.ForeignKey('User',on_delete=models.CASCADE)
    def __str__(self):
        return self.review

class Link(models.Model):
    link_type = models.CharField(max_length=20)
    address = models.URLField(max_length=500)
    movie = models.ForeignKey('Movie', on_delete=models.CASCADE)
    def __str__(self):
        return self.address

class Relation(models.Model):
    rel_type = models.CharField(max_length=20)
    src_movie = models.ForeignKey('Movie', on_delete=models.CASCADE, related_name="source")
    dst_movie = models.ForeignKey('Movie', on_delete=models.CASCADE, related_name="destination")

    def __str__(self):
        return self.rel_type


class Category(models.Model):
    name = models.CharField(max_length=30)
    movie = models.ManyToManyField('Movie')
    def __str__(self):
        return self.name

class Appointment(models.Model):
    name = models.CharField(max_length=30)
    movie = models.ForeignKey('Movie', on_delete=models.CASCADE)
    actor = models.ForeignKey('Person', on_delete=models.CASCADE)
    def __str__(self):
        return self.name

class Person(models.Model):
    first_name = models.CharField(max_length=100)
    last_name = models.CharField(max_length=100)
    bio = models.TextField(null=True, blank=True)
    birth_date = models.DateField(null=True, blank=True)
    birth_place = models.CharField(max_length=100, null=True, blank=True)
    def __str__(self):
        return self.first_name + " " + self.last_name





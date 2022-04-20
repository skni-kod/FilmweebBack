from operator import mod
from tkinter import CASCADE
from django.db import models

class Links(models.Model):
    link_type = models.CharField(max_length=20)
    address = models.URLField(max_length=500)
    movie_id = models.ForeignKey(_, on_delete=models.CASCADE)
import imp
from django import views
from django.http import HttpResponse
from django.shortcuts import render
from database.serializers import MovieSerializer
from rest_framework import viewsets
from database.models import Movie

# Create your views here.

def index(request):
    return HttpResponse("Test response")

class MovieViewSet(viewsets.ModelViewSet):
    queryset = Movie.objects.all()
    serializer_class = MovieSerializer
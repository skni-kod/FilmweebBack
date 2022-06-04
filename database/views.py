import imp
from django import views
from django.http import HttpResponse
from django.shortcuts import render, redirect, get_list_or_404, get_object_or_404
from rest_framework import viewsets
from rest_framework.response import Response
from rest_framework.decorators import action

from .models import *
from .serializers import *

#from .models import Profile

# Create your views here.

def index(request):
    return HttpResponse("Test response")

class MovieViewSet(viewsets.ModelViewSet):
    serializer_class = MovieSerializer
    queryset = Movie.objects.all()

    def list(self, request):
        queryset = Movie.objects.all()
        serializer = MovieSerializer(queryset, many=True)
        return Response(serializer.data)

    def retrieve(self, request, pk=None):
        queryset = Movie.objects.all()
        user = get_object_or_404(queryset, pk=pk)
        serializer = MovieSerializer(user)
        return Response(serializer.data)

    @action(detail=True, methods=['get'])
    def reviews(self, request, pk=None):
        movie = Movie.objects.get(id=pk)
        serializer = ReviewSerializer(
            movie.review_set, many=True, context={"request": request}
        )
        return Response(serializer.data)

    @action(detail=True, methods=['get'])
    def comments(self, request, pk=None):
        movie = Movie.objects.get(id=pk)
        serializer = MovieCommentSerializer(
            movie.moviecomment_set, many=True, context={"request": request}
        )
        return Response(serializer.data)

    @action(detail=True, methods=['get'])
    def marks(self, request, pk=None):
        movie = Movie.objects.get(id=pk)
        serializer = MovieMarkSerializer(
            movie.moviemark_set, many=True, context={"request": request}
        )
        return Response(serializer.data)
    
    @action(detail=True, methods=['get'])
    def links(self, request, pk=None):
        movie = Movie.objects.get(id=pk)
        serializer = LinkSerializer(
            movie.link_set, many=True, context={"request": request}
        )
        return Response(serializer.data)

class ProfileViewSet(viewsets.ModelViewSet):
    serializer_class = ProfileSerializer
    queryset = Profile.objects.all()

    def list(self, request):
        queryset = Profile.objects.all()
        serializer = ProfileSerializer(queryset, many=True)
        return Response(serializer.data)

    def retrieve(self, request, pk=None):
        queryset = Profile.objects.all()
        user = get_object_or_404(queryset, pk=pk)
        serializer = ProfileSerializer(user)
        return Response(serializer.data)
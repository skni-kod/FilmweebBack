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

class MovieMarkViewSet(viewsets.ModelViewSet):
    serializer_class = MovieMarkSerializer
    queryset = MovieMark.objects.all()

    def list(self, request):
        queryset = MovieMark.objects.all()
        serializer = MovieMarkSerializer(queryset, many=True)
        return Response(serializer.data)

    def retrieve(self, request, pk=None):
        queryset = MovieMark.objects.all()
        user = get_object_or_404(queryset, pk=pk)
        serializer = MovieMarkSerializer(user)
        return Response(serializer.data)
        return Response(serializer.data)

class ProfileViewSet(viewsets.ModelViewSet):
    def get(self, request, pk=None, format=None):
        queryset = self.get_object(pk)
        serializer_class = ProfileSerializer
        return Response(serializer_class.data)

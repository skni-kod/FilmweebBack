import imp
from django import views
from django.http import HttpResponse
from django.shortcuts import render, redirect, get_list_or_404, get_object_or_404
from rest_framework import viewsets
from rest_framework.response import Response
from rest_framework.decorators import action
from rest_framework.views import APIView

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
        serializer = ReviewSerializer2(
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

    @action(detail=True, methods=['get'])
    def random(self, request, pk=None):
        movie = Movie.objects.order_by('?')[:4]
        serializer = RandomMovieSerializer(movie,many=True,context={"request": request})
        return Response(serializer.data)

    @action(detail=True, methods=['get'])
    def actors(self, request, pk=None):
        movie = Movie.objects.raw('SELECT * FROM database_person p JOIN database_appointment a ON p.id = a.actor_id WHERE a.name = %s', ['actor'])
        serializer = PersonSerializer(movie,many=True,context={"request": request})
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

class UserViewSet(viewsets.ModelViewSet):
    serializer_class = UserSerializer
    queryset = User.objects.all()    
    
    def list(self, request):
        queryset = User.objects.all()
        serializer = UserSerializer(queryset, many=True)
        return Response(serializer.data)

    def retrieve(self, request, pk=None):
        queryset = User.objects.all()
        user = get_object_or_404(queryset, pk=pk)
        serializer = UserSerializer(user)
        return Response(serializer.data)

    @action(detail=True, methods=['get'])
    def reviews(self, request, pk=None):
        user = User.objects.get(id=pk)
        serializer = ReviewSerializer(
            user.review_set, many=True, context={"request": request}
        )
        return Response(serializer.data)

class PersonViewSet(viewsets.ModelViewSet):
    serializer_class = PersonSerializer
    queryset = Person.objects.all()

    def list(self, request):
        queryset = Person.objects.all()
        serializer = PersonSerializer(queryset, many=True)
        return Response(serializer.data)

    def retrieve(self, request, pk=None):
        queryset = Person.objects.all()
        person = get_object_or_404(queryset, pk=pk)
        serializer = PersonSerializer(person)
        return Response(serializer.data)
    
    @action(detail=True, methods=['get'])
    def mark(self, request, pk=None):
        person_mark = Person.objects.get(id=pk)
        serializer = PersonMarkSerializer(
            person_mark.personmark_set, many=True, context={"request": request}
        )
        return Response(serializer.data)

class ReviewViewSet(viewsets.ModelViewSet):
    serializer_class = ReviewSerializer
    queryset = Review.objects.all()

    def list(self, request):
        queryset = Review.objects.all()
        serializer = ReviewSerializer(queryset, many=True)
        return Response(serializer.data)

    def retrieve(self, request, pk=None):
        queryset = Review.objects.all()
        person = get_object_or_404(queryset, pk=pk)
        serializer = ReviewSerializer(person)
        return Response(serializer.data)
    
    @action(detail=True, methods=['get'])
    def comments(self, request, pk=None):
        user = Review.objects.get(id=pk)
        serializer = ReviewCommentSerializer(
            user.reviewcomment_set, many=True, context={"request": request}
        )
        return Response(serializer.data)

class ActorViewPerLastNameDetail(APIView):

    def get(self, request, last_name):
        queryset = Person.objects.raw('SELECT * FROM database_person p JOIN database_appointment a ON p.id = a.actor_id WHERE a.name = %s AND p.last_name = %s', ['actor', last_name])
        serializer = PersonSerializer(queryset, many=True)
        return Response(serializer.data)

class ActorViewPerIdDetail(APIView):

    def get(self, request, actor_id):
        queryset = Person.objects.raw('SELECT * FROM database_person p JOIN database_appointment a ON p.id = a.actor_id WHERE a.name = %s AND p.id = %s', ['actor', actor_id])
        serializer = PersonSerializer(queryset, many=True)
        return Response(serializer.data)

class AverageMovieMarkView(APIView):

    def get(self, request, movie_id):
        queryset = MovieMark.objects.raw('SELECT id, AVG(mark) FROM database_moviemark mm WHERE mm.movie_id = %s', [movie_id])
        serializer = AverageMovieMarkSerializer(queryset, many=True, context={'movie_id': movie_id})
        return Response(serializer.data)

class AverageActorMarkView(APIView):

    def get(self, request, person_id):
        queryset = PersonMark.objects.raw('SELECT id, AVG(mark) FROM database_personmark pm WHERE pm.person_id = %s', [person_id])
        serializer = AveragePersonMarkSerializer(queryset, many=True, context={'person_id': person_id})
        return Response(serializer.data)


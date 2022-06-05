from typing import List
from rest_framework import serializers
import database
from database.models import *
from django.db.models import Avg

#These serializers as-is only provide one with basic access to the database.
#Any updating/addidion lies in the hands of person implementing given functionality

class MovieSerializer(serializers.ModelSerializer):
    class Meta:
        model = Movie
        fields = ['original_title', 'production_year', 'production_country','airing_date', 'duration', 'description', 'title']

class UserSerializer(serializers.ModelSerializer):
    class Meta:
        model = User
        fields = ['email', 'passwd', 'birth_date', 'is_admin']

class ProfileSerializer(serializers.ModelSerializer):
    class Meta:
        model = Profile
        fields = ['nick', 'first_name', 'last_name', 'avatar', 'user']

class ListSerializer(serializers.ModelSerializer):
    class Meta:
        model = database.models.List
        fields = ['list_name', 'nick', 'movies']

class MovieMarkSerializer(serializers.ModelSerializer):
    class Meta:
        model = MovieMark
        fields = ['mark', 'movie', 'user']

class AverageMovieMarkSerializer(serializers.ModelSerializer):
    average_mark = serializers.SerializerMethodField()
    class Meta:

        fields = ['average_mark']
        model = MovieMark

    def get_average_mark(self, obj):
        movie_id = self.context.get("movie_id")
        average = MovieMark.objects.filter(movie_id = movie_id).aggregate(Avg('mark')).get('mark__avg')

        if average == None:
            return 0
        return average

class PersonMarkSerializer(serializers.ModelSerializer):
    class Meta:
        model = PersonMark
        fields = ['mark', 'person', 'user']

class MovieCommentSerializer(serializers.ModelSerializer):
    class Meta: 
        model = MovieComment
        fields = ['comment', 'movie', 'user']

class ReviewCommentSerializer(serializers.ModelSerializer):
    class Meta:
        model = ReviewComment
        fields = ['comment', 'review', 'user']

class ReviewSerializer(serializers.ModelSerializer):
    class Meta:
        model = Review
        fields = ['review', 'review_type', 'creation_date', 'movie', 'user']

class LinkSerializer(serializers.ModelSerializer):
    class Meta:
        model = Link
        fields = ['link_type', 'address', 'movie']

class RelationSerializer(serializers.ModelSerializer):
    class Meta:
        model = Relation
        fields = ['rel_type', 'src_movie', 'dst_movie']

class CategorySerializer(serializers.ModelSerializer):
    class Meta: 
        model = Category
        fields = ['name', 'movies']

class AppointmentSerializer(serializers.ModelSerializer):
    class Meta:
        model = Appointment
        fields = ['name', 'movie', 'actor']

class PersonSerializer(serializers.ModelSerializer):
    class Meta:
        model = Person
        fields = ['first_name', 'last_name', 'bio', 'birth_date', 'birth_place']

class RandomMovieSerializer(serializers.ModelSerializer):
    class Meta:
        model=Movie
        fields = ['id','title','original_title','production_year','poster']

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
        fields = ['id','original_title', 'production_year', 'production_country','airing_date', 'duration', 'description', 'title']

class MovieSerializer2(serializers.ModelSerializer):
    class Meta:
        model = Movie
        fields = ['id','original_title', 'production_year', 'production_country','airing_date', 'duration', 'description', 'title', 'poster']

class UserSerializer(serializers.ModelSerializer):
    class Meta:
        model = User
        fields = ['id','email', 'passwd', 'birth_date', 'is_admin']

class ProfileSerializer(serializers.ModelSerializer):
    class Meta:
        model = Profile
        fields = ['id','nick', 'first_name', 'last_name', 'avatar', 'user']

class ListSerializer(serializers.ModelSerializer):
    class Meta:
        model = database.models.List
        fields = ['id','list_name', 'nick', 'movies']

class MovieMarkSerializer(serializers.ModelSerializer):
    class Meta:
        model = MovieMark
        fields = ['id','mark', 'movie', 'user']

class AverageMovieMarkSerializer(serializers.ModelSerializer):
    average_mark = serializers.SerializerMethodField()
    class Meta:

        fields = ['id','average_mark']
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
        fields = ['id','mark', 'person', 'user']

class AveragePersonMarkSerializer(serializers.ModelSerializer):
    average_mark = serializers.SerializerMethodField()
    class Meta:

        fields = ['id','average_mark']
        model = PersonMark

    def get_average_mark(self, obj):
        person_id = self.context.get("person_id")
        average = PersonMark.objects.filter(person_id = person_id).aggregate(Avg('mark')).get('mark__avg')

        if average == None:
            return 0
        return average

class MovieCommentSerializer(serializers.ModelSerializer):
    class Meta: 
        model = MovieComment
        fields = ['id','comment', 'user','movie_id']

class MovieCommentSerializer2(serializers.ModelSerializer):
    nick = serializers.SerializerMethodField()
    avatar = serializers.SerializerMethodField()

    class Meta:
        model = MovieComment
        fields = ['id','comment','movie_id', 'user', 'nick', 'avatar']
    
    def get_nick(self, obj):
        nick = Profile.objects.filter(user_id = obj.user_id).values('nick')
        return nick

    def get_avatar(self, obj):
        avatar = Profile.objects.filter(user_id = obj.user_id).values('avatar')
        return avatar

class ReviewCommentSerializer(serializers.ModelSerializer):
    class Meta:
        model = ReviewComment
        fields = ['id','comment', 'review', 'user']

class ReviewCommentSerializer2(serializers.ModelSerializer):
    nick = serializers.SerializerMethodField()
    avatar = serializers.SerializerMethodField()

    class Meta:
        model = ReviewComment
        fields = ['id','comment', 'review', 'user', 'nick', 'avatar']

    def get_nick(self, obj):
        nick = Profile.objects.filter(user_id = obj.user_id).values('nick')
        return nick

    def get_avatar(self, obj):
        avatar = Profile.objects.filter(user_id = obj.user_id).values('avatar')
        return avatar

class ReviewSerializer(serializers.ModelSerializer):
    class Meta:
        model = Review
        fields = ['id','review', 'review_type', 'creation_date', 'user']

class ReviewSerializer2(serializers.ModelSerializer):
    nick = serializers.SerializerMethodField()
    avatar = serializers.SerializerMethodField()

    class Meta:
        model = Review
        fields = ['id','review', 'review_type', 'creation_date', 'user', 'nick', 'avatar']
    
    def get_nick(self, obj):
        nick = Profile.objects.filter(user_id = obj.user_id).values('nick')
        return nick

    def get_avatar(self, obj):
        avatar = Profile.objects.filter(user_id = obj.user_id).values('avatar')
        return avatar

class LinkSerializer(serializers.ModelSerializer):
    class Meta:
        model = Link
        fields = ['id','link_type', 'address', 'movie']

class RelationSerializer(serializers.ModelSerializer):
    class Meta:
        model = Relation
        fields = ['id','rel_type', 'src_movie', 'dst_movie']

class CategorySerializer(serializers.ModelSerializer):
    class Meta: 
        model = Category
        fields = ['id','name', 'movies']

class CategorySerializer2(serializers.ModelSerializer):
    class Meta: 
        model = Category
        fields = ['name']

class AppointmentSerializer(serializers.ModelSerializer):
    class Meta:
        model = Appointment
        fields = ['id','name', 'movie', 'actor']

class PersonSerializer(serializers.ModelSerializer):
    class Meta:
        model = Person
        fields = ['id','first_name', 'last_name', 'bio', 'birth_date', 'birth_place']

class ActorSerializer(serializers.ModelSerializer):
    role = serializers.SerializerMethodField()
    
    class Meta:
        model = Person
        fields = ['id', 'role', 'first_name', 'last_name']

    def get_role(self, obj):
        role = Appointment.objects.filter(actor_id = obj.id).values('role')
        return role

class RandomMovieSerializer(serializers.ModelSerializer):
    class Meta:
        model=Movie
        fields = ['id','title','original_title','production_year','poster']
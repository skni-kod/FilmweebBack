from csv import DictReader
from django.core.management import BaseCommand

from database.models import MovieMark,Movie,User
class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if MovieMark.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/MovieMark.csv')):
            tmp=MovieMark(mark=row['Mmark'],movie=Movie.objects.get(id=row['movie_id']),user=User.objects.get(id=row['user_id']))
            tmp.save()

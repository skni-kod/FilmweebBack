from csv import DictReader
from django.core.management import BaseCommand

from database.models import Movie,MovieComment,User
class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if MovieComment.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/MovieComment.csv')):
            tmp=MovieComment(comment=row['Ccomment'],user=User.objects.get(id=row['user_id']),movie=Movie.objects.get(id=row['movie_id']))
            tmp.save()

from csv import DictReader
from django.core.management import BaseCommand

from database.models import Review,Movie,User
class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if Review.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/Review.csv')):
            tmp=Review(review=row['Rreview'],review_type=row['review_type'],creation_date=row['creation_date'],movie=Movie.objects.get(id=row['movie_id']),user=User.objects.get(id=row['user_id']))
            tmp.save()

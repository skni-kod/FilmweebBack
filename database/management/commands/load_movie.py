from csv import DictReader
from django.core.management import BaseCommand

from database.models import Movie

class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if Movie.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/Movie.csv')):
            tmp=Movie(original_title=row['Ooryginal_title'], production_year=row['production_year'], production_country=row['production_country'], airing_date=row['airing_date'], duration=row['duration'],description=row['description'], title=row['title'])  
            tmp.save()
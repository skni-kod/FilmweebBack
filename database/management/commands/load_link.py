from csv import DictReader
from django.core.management import BaseCommand

from database.models import Link,Movie

class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if Link.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/Link.csv')):
            tmp=Link(link_type=row['Llink_type'],address=row['address'],movie=Movie.objects.get(id=row['movie_id'])) 
            tmp.save()

from csv import DictReader
from django.core.management import BaseCommand

from database.models import Category
class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if Category.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/Category.csv')):
            tmp=Category(name=row['Nname'])
            tmp.save()

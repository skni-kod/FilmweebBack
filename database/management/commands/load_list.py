from csv import DictReader
from django.core.management import BaseCommand

from database.models import List, User

class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if List.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/List.csv')):
            tmp=List(list_name=row['Llist_name'],nick=User.objects.get(id=row['nick_id']))
            tmp.save()

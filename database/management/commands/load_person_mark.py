from csv import DictReader
from django.core.management import BaseCommand

from database.models import PersonMark,Person,User
class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if PersonMark.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/PersonMark.csv')):
            tmp=PersonMark(mark=row['Mmark'],person=Person.objects.get(id=row['person_id']),user=User.objects.get(id=row['user_id']))
            tmp.save()

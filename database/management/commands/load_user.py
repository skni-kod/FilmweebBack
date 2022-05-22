from csv import DictReader
from django.core.management import BaseCommand

from database.models import User

class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if User.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/User.csv')):
            tmp=User(email=row['Eemail'],passwd=row['passwd'],birth_date=row['birth_date'],is_admin=row['is_admin'])
            tmp.save()

from csv import DictReader
from django.core.management import BaseCommand

from database.models import Person

class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if Person.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/Person.csv')):
            tmp_person=Person(first_name=row['Ffirst_name'], last_name=row['last_name'], bio=row['bio'], birth_date=row['birth_date'], birth_place=row['birth_place'])  
            tmp_person.save()

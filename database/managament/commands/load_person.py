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

        for row in DictReader(open('.dataImport/Person.csv')):
            tmp_person=Person(first_name=row['Name'], last_name=row['LastName'], bio=row['Bio'], birth_date=['Date'], birth_place=['Country'])  
            tmp_person.save()
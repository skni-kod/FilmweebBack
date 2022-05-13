from csv import DictReader
from django.core.management import BaseCommand

from database.models import Appointment

class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if Appointment.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/Appointment.csv')):
            tmp=Appointment(name=row['Nname'],movie=row['movie_id'],person=row['person_id'])  
            tmp.save()
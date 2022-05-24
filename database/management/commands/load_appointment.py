from csv import DictReader
from django.core.management import BaseCommand

from database.models import Appointment,Movie,Person

class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if Appointment.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/Appointment.csv')):
            tmp=Appointment(name=row['Nname'],movie=Movie.objects.get(id=row['movie_id']),actor=Person.objects.get(id=row['person_id']))  
            tmp.save()

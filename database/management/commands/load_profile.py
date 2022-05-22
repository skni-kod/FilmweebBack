from csv import DictReader
from django.core.management import BaseCommand

from database.models import Profile,User
class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if Profile.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/Profile.csv')):
            tmp=Profile(nick=row['Nnick'],first_name=row['last_name'],last_name=row['last_name'],avatar=row['avatar'],user=User.objects.get(id=row['user_id']))
            tmp.save()

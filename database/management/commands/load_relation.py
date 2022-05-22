from csv import DictReader
from django.core.management import BaseCommand

from database.models import Relation,Movie
class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if Relation.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/Relation.csv')):
            tmp=Relation(rel_type=row['Rrel_type'],src_movie=Movie.objects.get(id=row['src_movie_id']),dst_movie=Movie.objects.get(id=row['dst_movie_id']))
            tmp.save()

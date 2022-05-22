from csv import DictReader
from django.core.management import BaseCommand

from database.models import ReviewComment,Review,User
class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):
    
        if ReviewComment.objects.exists():
            print("Import error")
            return
            
        print("Importing data...")

        for row in DictReader(open('./dataImport/ReviewComment.csv')):
            tmp=ReviewComment(comment=row['Ccomment'],review=Review.objects.get(id=row['review_id']),user=User.objects.get(id=row['user_id']))
            tmp.save()

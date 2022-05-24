from csv import DictReader

from django.core.management import BaseCommand

from database.models import *


class Command(BaseCommand):
    help = "Load data into model"

    def handle(self, *args, **options):

        if Movie.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/Movie.csv')):
            tmp = Movie(original_title=row['Ooryginal_title'], production_year=row['production_year'], production_country=row['production_country'],
                         airing_date=row['airing_date'], duration=row['duration'], description=row['description'], title=row['title'])
            tmp.save()

        if Category.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/Category.csv')):
            tmp = Category(name=row['Nname'])
            tmp.save()

        if Link.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/Link.csv')):
            tmp = Link(link_type=row['Llink_type'], address=row['address'],
                       movie=Movie.objects.get(id=row['movie_id']))
            tmp.save()

        if Person.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/Person.csv')):
            tmp_person = Person(first_name=row['Ffirst_name'], last_name=row['last_name'],
                                bio=row['bio'], birth_date=row['birth_date'], birth_place=row['birth_place'])
            tmp_person.save()

        if User.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/User.csv')):
            tmp = User(email=row['Eemail'], passwd=row['passwd'],
                       birth_date=row['birth_date'], is_admin=row['is_admin'])
            tmp.save()

        if List.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/List.csv')):
            tmp=List(list_name=row['Llist_name'],nick=User.objects.get(id=row['nick_id']))
            tmp.save()

        if Review.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/Review.csv')):
            tmp=Review(review=row['Rreview'],review_type=row['review_type'],creation_date=row['creation_date'],movie=Movie.objects.get(id=row['movie_id']),user=User.objects.get(id=row['user_id']))
            tmp.save()



        if Appointment.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/Appointment.csv')):
            tmp=Appointment(name=row['Nname'],movie=Movie.objects.get(id=row['movie_id']),actor=Person.objects.get(id=row['person_id']))  
            tmp.save()


        if MovieComment.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/MovieComment.csv')):
            tmp=MovieComment(comment=row['Ccomment'],user=User.objects.get(id=row['user_id']),movie=Movie.objects.get(id=row['movie_id']))
            tmp.save()

        if MovieMark.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/MovieMark.csv')):
            tmp=MovieMark(mark=row['Mmark'],movie=Movie.objects.get(id=row['movie_id']),user=User.objects.get(id=row['user_id']))
            tmp.save()


        if PersonMark.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/PersonMark.csv')):
            tmp=PersonMark(mark=row['Mmark'],person=Person.objects.get(id=row['person_id']),user=User.objects.get(id=row['user_id']))
            tmp.save()


        if Profile.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/Profile.csv')):
            tmp=Profile(nick=row['Nnick'],first_name=row['last_name'],last_name=row['last_name'],avatar=row['avatar'],user=User.objects.get(id=row['user_id']))
            tmp.save()
        if Relation.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/Relation.csv')):
            tmp=Relation(rel_type=row['Rrel_type'],src_movie=Movie.objects.get(id=row['src_movie_id']),dst_movie=Movie.objects.get(id=row['dst_movie_id']))
            tmp.save()
        if ReviewComment.objects.exists():
            print("Import error")
            return

        print("Importing data...")

        for row in DictReader(open('./importData/ReviewComment.csv')):
            tmp=ReviewComment(comment=row['Ccomment'],review=Review.objects.get(id=row['review_id']),user=User.objects.get(id=row['user_id']))
            tmp.save()



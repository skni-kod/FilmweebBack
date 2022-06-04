from django.contrib import admin
from django.apps import apps

database = apps.get_app_config('database')
for model in database.get_models():
    admin.site.register(model)